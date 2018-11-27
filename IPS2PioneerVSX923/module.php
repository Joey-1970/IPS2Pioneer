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
		$this->RegisterPropertyString("InputDevices", "");
		
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
		
		$arrayColumns = array();
		$arrayColumns[] = array("label" => "Pioneer Nr.", "name" => "PioneerNr", "width" => "120px", "save" => true);
		$arrayColumns[] = array("label" => "Pioneer Name", "name" => "PioneerName", "width" => "240px", "save" => true);
		$arrayColumns[] = array("label" => "Aktiv", "name" => "Activ", "width" => "60px", "add" => "", "edit" => array("type" => "CheckBox", "name" => "Activ", "caption" => "Aktiv"));
		$arrayColumns[] = array("label" => "Eigener Name", "name" => "MyName", "width" => "240px", "add" => "", "edit" => array("type" => "ValidationTextBox", "name" => "MyName", "caption" => "Mein Name"));
		
		$arrayValues = array();
		$arrayValues[] = array("PioneerNr" => 25, "PioneerName" => "BD", "Activ" => true, "MyName" => "BD");
		$arrayValues[] = array("PioneerNr" => 04, "PioneerName" => "DVD", "Activ" => true, "MyName" => "DVD");
		$arrayValues[] = array("PioneerNr" => 05, "PioneerName" => "TV/SAT", "Activ" => true, "MyName" => "TV/SAT");
		$arrayValues[] = array("PioneerNr" => 15, "PioneerName" => "DVR/BDR", "Activ" => true, "MyName" => "DVR/BDR");
		$arrayValues[] = array("PioneerNr" => 10, "PioneerName" => "VIDEO 1(VIDEO)", "Activ" => true, "MyName" => "VIDEO 1(VIDEO)");
		$arrayValues[] = array("PioneerNr" => 14, "PioneerName" => "VIDEO 2", "Activ" => true, "MyName" => "VIDEO 2");
		$arrayValues[] = array("PioneerNr" => 19, "PioneerName" => "HDMI 1", "Activ" => true, "MyName" => "HDMI 1");
		$arrayValues[] = array("PioneerNr" => 20, "PioneerName" => "HDMI 2", "Activ" => true, "MyName" => "HDMI 2");
		$arrayValues[] = array("PioneerNr" => 21, "PioneerName" => "HDMI 3", "Activ" => true, "MyName" => "HDMI 3");
		$arrayValues[] = array("PioneerNr" => 22, "PioneerName" => "HDMI 4", "Activ" => true, "MyName" => "HDMI 4");
		$arrayValues[] = array("PioneerNr" => 23, "PioneerName" => "HDMI 5", "Activ" => true, "MyName" => "HDMI 5");
		$arrayValues[] = array("PioneerNr" => 24, "PioneerName" => "HDMI 6", "Activ" => true, "MyName" => "HDMI 6");
		$arrayValues[] = array("PioneerNr" => 26, "PioneerName" => "HOME MEDIA GALLERY", "Activ" => true, "MyName" => "HOME MEDIA GALLERY");
		$arrayValues[] = array("PioneerNr" => 17, "PioneerName" => "iPod/USB", "Activ" => true, "MyName" => "iPod/USB");
		$arrayValues[] = array("PioneerNr" => 1, "PioneerName" => "CD", "Activ" => true, "MyName" => "CD");
		$arrayValues[] = array("PioneerNr" => 3, "PioneerName" => "CD-R/TAPE", "Activ" => true, "MyName" => "CD-R/TAPE");
		$arrayValues[] = array("PioneerNr" => 2, "PioneerName" => "TUNER", "Activ" => true, "MyName" => "TUNER");
		$arrayValues[] = array("PioneerNr" => 0, "PioneerName" => "PHONO", "Activ" => true, "MyName" => "PHONO");
		$arrayValues[] = array("PioneerNr" => 12, "PioneerName" => "MULTI CH IN", "Activ" => true, "MyName" => "MULTI CH IN");
		$arrayValues[] = array("PioneerNr" => 33, "PioneerName" => "ADAPTER PORT", "Activ" => true, "MyName" => "ADAPTER PORT");
		$arrayValues[] = array("PioneerNr" => 27, "PioneerName" => "SIRIUS", "Activ" => true, "MyName" => "SIRIUS");
		$arrayValues[] = array("PioneerNr" => 31, "PioneerName" => "HDMI (cyclic)", "Activ" => true, "MyName" => "HDMI (cyclic)");
		
		$arrayElements[] = array("type" => "List", "name" => "InputDevices", "caption" => "Geräte", "rowCount" => 15, "add" => false, "delete" => false, "columns" => $arrayColumns, "values" => $arrayValues);
				
		
		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements)); 		 
 	} 
	
	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();
		
		
		
		// Profile anlegen
		$this->RegisterProfileFloat("IPS2Pioneer.dB", "Melody", "", " dB", -80, 12, 0.5, 1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.Volume", "Shutter", "", "", 0, 1, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Volume", 0, "+", "Shutter", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Volume", 1, "-", "Shutter", -1);
		
		// Statusvariablen anlegen
		$this->RegisterVariableInteger("LastKeepAlive", "Letztes Keep Alive", "~UnixTimestamp", 10);
		$this->DisableAction("LastKeepAlive");
		
		$this->RegisterVariableBoolean("Power", "Power", "~Switch", 20);
		$this->EnableAction("Power");
		
		$this->RegisterVariableInteger("Input", "Input", "", 30);
		$this->EnableAction("Input");
		
		$this->RegisterVariableFloat("Volume", "Volume", "IPS2Pioneer.dB", 40);
		$this->EnableAction("Volume");
		
		$this->RegisterVariableInteger("VolumeUpDown", "Volume", "IPS2Pioneer.Volume", 50);
		$this->EnableAction("VolumeUpDown");
		
		$this->RegisterVariableString("Display", "Display", "", 60);
		
		$this->RegisterVariableBoolean("Mute", "Mute", "~Switch", 70);
		$this->EnableAction("Mute");
		
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
			case "MUT0":
				SetValueBoolean($this->GetIDForIdent("Mute"), true);
				break;
			case "MUT1":
				SetValueBoolean($this->GetIDForIdent("Mute"), false);
				break;
			case preg_match('/FN.*/', $Message) ? $Message : !$Message:
				SetValueInteger($this->GetIDForIdent("Input"), intval(substr($Message, -2)));
				break;
			case preg_match('/VOL.*/', $Message) ? $Message : !$Message:
				$Volume = intval(substr($Message, -3));
				$Volume = ($Volume - 161) / 2;
				SetValueFloat($this->GetIDForIdent("Volume"), $Volume);
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
  		If (($this->ReadPropertyBoolean("Open") == true) AND ($this->GetParentStatus() == 102)) {
			switch($Ident) {
				case "Power":
					If (GetValueBoolean($this->GetIDForIdent("Power")) == true) {
						$this->SetData("PF");
					}
					else {
						$this->SetData("PO");
					}
					break;
				case "Mute":
					If (GetValueBoolean($this->GetIDForIdent("Mute")) == true) {
						$this->SetData("MF");
					}
					else {
						$this->SetData("MO");
					}
					break;
				case "Volume":
					$Volume = ($Value * 2) + 161; 
					$Volume = str_pad($Volume, 3, '0', STR_PAD_LEFT);
					$this->SetData($Volume."VL");
					break;
				case "VolumeUpDown":
					SetValueInteger($this->GetIDForIdent("VolumeUpDown"), $Value);
					If ($Value == 0) {
						$this->SetData("VU");
					}
					elseIf ($Value == 1) {
						$this->SetData("VD");
					}
					break;

				default:
				    throw new Exception("Invalid Ident");
			}
	    	}
		
	}
	
	private function GetData()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("GetData", "Ausfuehrung", 0);
			$MessageArray = array("?P", "?F", "?V", "?FL", "?M");
			foreach ($MessageArray as $Value) {
				$Message = $Value.chr(13);
				$Result = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => utf8_encode($Message))));
				IPS_Sleep(100);
			}
		}
	}
	
	private function SetData(String $Message)
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$Message = $Message.chr(13);
			$Result = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => utf8_encode($Message))));
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
	
	private function RegisterProfileFloat($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits)
	{
	        if (!IPS_VariableProfileExists($Name))
	        {
	            IPS_CreateVariableProfile($Name, 2);
	        }
	        else
	        {
	            $profile = IPS_GetVariableProfile($Name);
	            if ($profile['ProfileType'] != 2)
	                throw new Exception("Variable profile type does not match for profile " . $Name);
	        }
	        IPS_SetVariableProfileIcon($Name, $Icon);
	        IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
	        IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize);
	        IPS_SetVariableProfileDigits($Name, $Digits);
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
