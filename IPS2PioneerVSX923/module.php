<?
class IPS2PioneerVSX923 extends IPSModule
{
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
           	$this->RequireParent("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}");
		$this->RegisterPropertyBoolean("Open", false);
	    	$this->RegisterPropertyString("IPAddress", "127.0.0.1");
		
	}
	
	public function GetConfigurationForm() { 
		$arrayStatus = array(); 
		$arrayStatus[] = array("code" => 101, "icon" => "inactive", "caption" => "Instanz wird erstellt"); 
		$arrayStatus[] = array("code" => 102, "icon" => "active", "caption" => "Instanz ist aktiv");
		$arrayStatus[] = array("code" => 104, "icon" => "inactive", "caption" => "Instanz ist inaktiv");
		$arrayStatus[] = array("code" => 200, "icon" => "error", "caption" => "Instanz ist fehlerhaft"); 
		$arrayStatus[] = array("code" => 202, "icon" => "error", "caption" => "Kommunikationfehler!");
		
		$arrayElements = array(); 
		$arrayElements[] = array("name" => "Open", "type" => "CheckBox",  "caption" => "Aktiv"); 
		$arrayElements[] = array("type" => "ValidationTextBox", "name" => "IPAddress", "caption" => "IP");
 		$arrayElements[] = array("type" => "Label", "label" => "_____________________________________________________________________________________________________");
				
		
		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements)); 		 
 	} 
	
	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();
		
		
		
		// Profile anlegen
		
		$this->RegisterVariableInteger("LastKeepAlive", "Letztes Keep Alive", "~UnixTimestamp", 10);
		$this->DisableAction("LastKeepAlive");
		
		$this->RegisterVariableBoolean("Power", "Power", "~Switch", 20);
		$this->EnableAction("Power");
		
		$this->RegisterVariableInteger("Input", "Input", "", 30);
		$this->EnableAction("Input");
		
		$this->RegisterVariableInteger("Volume", "Volume", "", 40);
		$this->EnableAction("Volume");
		
		$this->RegisterVariableString("Display", "Display", "", 50);
		
		If (IPS_GetKernelRunlevel() == 10103) {
			$ParentID = $this->GetParentID();
			If ($ParentID > 0) {
				If (IPS_GetProperty($ParentID, 'Host') <> $this->ReadPropertyString('IPAddress')) {
		                	IPS_SetProperty($ParentID, 'Host', $this->ReadPropertyString('IPAddress'));
				}
				If (IPS_GetProperty($ParentID, 'Port') <> 8102) {
		                	IPS_SetProperty($ParentID, 'Port', 8102);
				}
				If (IPS_GetName($ParentID) == "Client Socket") {
		                	IPS_SetName($ParentID, "IPS2PioneerVSX923");
				}
				if(IPS_HasChanges($ParentID))
				{
				    	$Result = @IPS_ApplyChanges($ParentID);
					If ($Result) {
						$this->SendDebug("ApplyChanges", "Einrichtung des Client Socket erfolgreich", 0);
					}
					else {
						$this->SendDebug("ApplyChanges", "Einrichtung des Client Socket nicht erfolgreich!", 0);
					}
				}
			}
			
			If (($this->ReadPropertyBoolean("Open") == true) AND ($this->ConnectionTest() == true)) {
				
				$this->SetStatus(102);
				// Erste Abfrage der Daten
				$this->GetData();
			}
			else {
				$this->SetStatus(104);
			}	   
		}
	}
	
	public function ReceiveData($JSONString) {
 	    	//IPS_SemaphoreLeave("Communication");
		// Empfangene Daten vom I/O
	    	SetValueInteger($this->GetIDForIdent("LastKeepAlive"), time() );
		$Data = json_decode($JSONString);
		$Message = utf8_decode($Data->Buffer);
		// Entfernen der Steuerzeichen
		$Message = trim($Message, "\x00..\x1F");
		
		$this->SendDebug("ReceiveData", $Message, 0);
		
		switch($Message) {
			case "PWR0":
				SetValueBoolean($this->GetIDForIdent("Power"), true);
				break;
			case "PWR1":
				SetValueBoolean($this->GetIDForIdent("Power"), false);
				break;
			case preg_match('/FN.*/', $Message) ? $Message : !$Message:
				SetValueInteger($this->GetIDForIdent("Input"), intval(substr($Message, -2)));
				break;
			case preg_match('/VOL.*/', $Message) ? $Message : !$Message:
				SetValueInteger($this->GetIDForIdent("Volume"), intval(substr($Message, -3)));
				break;
			case preg_match('/FL.*/', $Message) ? $Message : !$Message:
				$Result = "";
				$Message = substr($Message, 2);
				$MessageArray = str_split($Message, 2);
				for ($i = 0; $i <= count($MessageArray) - 1; $i++) {
					If ($MessageArray[$i] <> 0x02) {
						$Sign = chr(hexdec($MessageArray[$i]));
						$Result = $Result.$Sign;
					}
				}
				$Result = trim($Result, " \t\n\r\0\x0B");
				SetValueString($this->GetIDForIdent("Display"), $Result);
				break;	
				
				
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
  		switch($Ident) {
			case "Power":
			    	If (($this->ReadPropertyBoolean("Open") == true) AND ($this->GetParentStatus() == 102)) {
					$this->ClientSocket("/A181AFBC/RU".chr(13));			
				}
				break;
			
			
			
			default:
			    throw new Exception("Invalid Ident");
	    	}
		
	}
	
	private function GetData()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("GetData", "Ausfuehrung", 0);
			$MessageArray = array("?P", "?F", "?V", "?FL");
			foreach ($MessageArray as $Value) {
				$Message = $Value.chr(13);
				$Result = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => utf8_encode($Message))));
				IPS_Sleep(100);
			}
		}
	}
	
	
	
	public function PowerOn()
	{
		If (($this->ReadPropertyBoolean("Open") == true) AND ($this->GetParentStatus() == 102)) {
			$this->ClientSocket("PN".chr(13));
			$this->Get_DataUpdate();
		}	
	}
	
	public function PowerOff()
	{
		If (($this->ReadPropertyBoolean("Open") == true) AND ($this->GetParentStatus() == 102)) {
			$this->ClientSocket("PF".chr(13));
			$this->Get_DataUpdate();
		}	
	}
	
	
	
	
	
	
	
	private function ConnectionTest()
	{
	      $result = false;
	      If (Sys_Ping($this->ReadPropertyString("IPAddress"), 2000)) {
			//IPS_LogMessage("IPS2PioneerBDP450","Angegebene IP ".$this->ReadPropertyString("IPAddress")." reagiert");
			$status = @fsockopen($this->ReadPropertyString("IPAddress"), 8102, $errno, $errstr, 10);
				if (!$status) {
					IPS_LogMessage("IPS2PioneerBDP450","Port ist geschlossen!");				
	   			}
	   			else {
	   				fclose($status);
					//IPS_LogMessage("IPS2PioneerBDP450","Port ist geöffnet");
					$result = true;
					$this->SetStatus(102);
	   			}
		}
		else {
			IPS_LogMessage("IPS2PioneerBDP450","IP ".$this->ReadPropertyString("IPAddress")." reagiert nicht!");
			$this->SetStatus(104);
		}
	return $result;
	}
	
	private function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize)
	{
	        if (!IPS_VariableProfileExists($Name))
	        {
	            IPS_CreateVariableProfile($Name, 1);
	        }
	        else
	        {
	            $profile = IPS_GetVariableProfile($Name);
	            if ($profile['ProfileType'] != 1)
	                throw new Exception("Variable profile type does not match for profile " . $Name);
	        }
	        IPS_SetVariableProfileIcon($Name, $Icon);
	        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
	        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);    
	}    
	
	private function GetParentID()
	{
		$ParentID = (IPS_GetInstance($this->InstanceID)['ConnectionID']);  
	return $ParentID;
	}
	
	private function GetParentStatus()
	{
		$Status = (IPS_GetInstance($this->GetParentID())['InstanceStatus']);  
	return $Status;
	}
	
	
}
?>