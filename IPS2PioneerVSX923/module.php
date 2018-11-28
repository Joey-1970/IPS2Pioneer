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
		$arrayValues[] = array("PioneerNr" => 34, "PioneerName" => "HDMI 7", "Activ" => true, "MyName" => "HDMI 7");
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
		$arrayValues[] = array("PioneerNr" => 48, "PioneerName" => "MHL", "Activ" => true, "MyName" => "MHL");
		
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
		
		$this->RegisterProfileInteger("IPS2Pioneer.Input", "Repeat", "", "", 0, 1, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Input", 0, "<", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Input", 1, ">", "Repeat", -1);
		
		$InputDeviceArray = $this->ReadPropertyString("InputDevices");
		$Data = json_decode($InputDeviceArray, true);
		
		$this->RegisterProfileInteger("IPS2Pioneer.InputSelect_".$this->InstanceID, "Repeat", "", "", 0, Count($Data), 0);
		
		for ($i = 0; $i <= count($Data) - 1; $i++) {
			$MyName = $Data[$i]["MyName"];
			$PioneerNr = $Data[$i]["PioneerNr"];
			$Activ = boolval($Data[$i]["Activ"]);
			
			If ($Activ == true) {
				$this->SendDebug("ApplyChanges", "Pioneer Nr: ".$PioneerNr." Mein Name: ".$MyName , 0);
				IPS_SetVariableProfileAssociation("IPS2Pioneer.InputSelect_".$this->InstanceID, intval($PioneerNr), $MyName, "Repeat", -1);
			}
			elseIf ($Activ == false) {
				//$this->SendDebug("ApplyChanges", "Nicht: Pioneer Nr: ".$PioneerNr." Mein Name: ".$MyName , 0);
				$Result = @IPS_SetVariableProfileAssociation("IPS2Pioneer.InputSelect_".$this->InstanceID, intval($PioneerNr), "", "", -1);
			}
		}
		
		
		// Statusvariablen anlegen
		$this->RegisterVariableInteger("LastKeepAlive", "Letztes Keep Alive", "~UnixTimestamp", 10);
		$this->DisableAction("LastKeepAlive");
		
		$this->RegisterVariableBoolean("Power", "Power", "~Switch", 20);
		$this->EnableAction("Power");
		
		$this->RegisterVariableInteger("Input", "Input", "IPS2Pioneer.InputSelect_".$this->InstanceID, 30);
		$this->EnableAction("Input");
		
		$this->RegisterVariableInteger("InputChange", "Input", "IPS2Pioneer.Input", 35);
		$this->EnableAction("InputChange");
		
		$this->RegisterVariableFloat("Volume", "Volume", "IPS2Pioneer.dB", 40);
		$this->EnableAction("Volume");
		
		$this->RegisterVariableInteger("VolumeUpDown", "Volume", "IPS2Pioneer.Volume", 50);
		$this->EnableAction("VolumeUpDown");
		
		$this->RegisterVariableString("Display", "Display", "", 60);
		
		$this->RegisterVariableString("ListeningMode", "ListeningMode", "", 70);
		
		$this->RegisterVariableBoolean("Mute", "Mute", "~Switch", 80);
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
				case "InputChange":
					SetValueInteger($this->GetIDForIdent("InputChange"), $Value);
					If ($Value == 0) {
						$this->SetData("FD");
					}
					elseIf ($Value == 1) {
						$this->SetData("FU");
					}
					break;
				case "Input":
					SetValueInteger($this->GetIDForIdent("Input"), $Value);
					$Input = str_pad($Value, 2, '0', STR_PAD_LEFT);
					$this->SetData($Input."FN");
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
			$this->SetData("PO");
		}	
	}
	
	public function PowerOff()
	{
		If (($this->ReadPropertyBoolean("Open") == true) AND ($this->GetParentStatus() == 102)) {
			$this->SetData("PF");
		}	
	}
	
	private function GetListeningMode(String $ListeningMode)
	{
		$Mode = array("0101" => "[)(]PLIIx MOVIE", "0102" => "[)(]PLII MOVIE", "0103" => "[)(]PLIIx MUSIC", 
				  "0104" => "[)(]PLII MUSIC", "0105" => "[)(]PLIIx GAME", "0106" => "[)(]PLII GAME", 
				  "0107" => "[)(]PROLOGIC", "0108" => "Neo", "0109" => "Neo", "010a" => "XM HD Surround", 
				  "010b" => "NEURAL SURR", "010c" => "2ch Straight Decode", "010d" => "[)(]PLIIz HEIGHT", 
				  "010e" => "WIDE SURR MOVIE", "010f" => "WIDE SURR MUSIC", "0110" => "STEREO", "0111" => "Neo", 
				  "0112" => "Neo", "0113" => "Neo", "0114" => "NEURAL SURROUND+Neo", "0115" => "NEURAL SURROUND+Neo", 
				  "0116" => "NEURAL SURROUND+Neo", "1101" => "[)(]PLIIx MOVIE", "1102" => "[)(]PLIIx MUSIC", 
				  "1103" => "[)(]DIGITAL EX", "1104" => "DTS +Neo", "1105" => "ES MATRIX", "1106" => "ES DISCRETE", 
				  "1107" => "DTS-ES 8ch", "1108" => "multi ch Straight Decode", "1109" => "[)(]PLIIz HEIGHT", 
				  "110a" => "WIDE SURR MOVIE", "110b" => "WIDE SURR MUSIC", "110c" => "ES Neo", "0201" => "ACTION", 
				  "0202" => "DRAMA", "0203" => "SCI-FI", "0204" => "MONOFILM", "0205" => "ENT.SHOW", 
				  "0206" => "EXPANDED", "0207" => "TV SURROUND", "0208" => "ADVANCEDGAME", "0209" => "SPORTS", 
				  "020a" => "CLASSICAL", "020b" => "ROCK/POP", "020c" => "UNPLUGGED", "020d" => "EXT.STEREO", 
				  "020e" => "PHONES SURR.", "020f" => "FRONT STAGE SURROUND ADVANCE FOCUS", 
				  "0210" => "FRONT STAGE SURROUND ADVANCE WIDE", "0211" => "SOUND RETRIEVER AIR", 
				  "0301" => "[)(]PLIIx MOVIE +THX", "0302" => "[)(]PLII MOVIE +THX", "0303" => "[)(]PL +THX CINEMA", 
				  "0304" => "Neo", "0305" => "THX CINEMA", "0306" => "[)(]PLIIx MUSIC +THX", 
				  "0307" => "[)(]PLII MUSIC +THX", "0308" => "[)(]PL +THX MUSIC", "0309" => "Neo", 
				  "030a" => "THX MUSIC", "030b" => "[)(]PLIIx GAME +THX", "030c" => "[)(]PLII GAME +THX", 
				  "030d" => "[)(]PL +THX GAMES", "030e" => "THX ULTRA2 GAMES", "030f" => "THX SELECT2 GAMES", 
				  "0310" => "THX GAMES", "0311" => "[)(]PLIIz +THX CINEMA", "0312" => "[)(]PLIIz +THX MUSIC", 
				  "0313" => "[)(]PLIIz +THX GAMES", "0314" => "Neo", "0315" => "Neo", "0316" => "Neo", 
				  "1301" => "THX Surr EX", "1302" => "Neo", "1303" => "ES MTRX +THX CINEMA", 
				  "1304" => "ES DISC +THX CINEMA", "1305" => "ES 8ch +THX CINEMA", "1306" => "[)(]PLIIx MOVIE +THX", 
				  "1307" => "THX ULTRA2 CINEMA", "1308" => "THX SELECT2 CINEMA", "1309" => "THX CINEMA", 
				  "130a" => "Neo", "130b" => "ES MTRX +THX MUSIC", "130c" => "ES DISC +THX MUSIC", 
				  "130d" => "ES 8ch +THX MUSIC", "130e" => "[)(]PLIIx MUSIC +THX", "130f" => "THX ULTRA2 MUSIC", 
				  "1310" => "THX SELECT2 MUSIC", "1311" => "THX MUSIC", "1312" => "Neo", 
				  "1313" => "ES MTRX +THX GAMES", "1314" => "ES DISC +THX GAMES", "1315" => "ES 8ch +THX GAMES", 
				  "1316" => "[)(]EX +THX GAMES", "1317" => "THX ULTRA2 GAMES", "1318" => "THX SELECT2 GAMES", 
				  "1319" => "THX GAMES", "131a" => "[)(]PLIIz +THX CINEMA", "131b" => "[)(]PLIIz +THX MUSIC", 
				  "131c" => "[)(]PLIIz +THX GAMES", "131d" => "Neo", "131e" => "Neo", "131f" => "Neo", 
				  "0401" => "STEREO", "0402" => "[)(]PLII MOVIE", "0403" => "[)(]PLIIx MOVIE", "0404" => "Neo", 
				  "0405" => "AUTO SURROUND Straight Decode", "0406" => "[)(]DIGITAL EX", "0407" => "[)(]PLIIx MOVIE", 
				  "0408" => "DTS +Neo", "0409" => "ES MATRIX", "040a" => "ES DISCRETE", "040b" => "DTS-ES 8ch",
				  "040c" => "XM HD Surround", "040d" => "NEURAL SURR", "040e" => "RETRIEVER AIR", "040f" => "Neo", 
				  "0410" => "ES Neo", "0501" => "STEREO", "0502" => "[)(]PLII MOVIE", "0503" => "[)(]PLIIx MOVIE", 
				  "0504" => "Neo", "0505" => "ALC Straight Decode", "0506" => "[)(]DIGITAL EX", 
				  "0507" => "[)(]PLIIx MOVIE", "0508" => "DTS +Neo", "0509" => "ES MATRIX", "050a" => "ES DISCRETE", 
				  "050b" => "DTS-ES 8ch", "050c" => "XM HD Surround", "050d" => "NEURAL SURR", 
				  "050e" => "RETRIEVER AIR", "050f" => "Neo", "0510" => "ES Neo", "0601" => "STEREO", 
				  "0602" => "[)(]PLII MOVIE", "0603" => "[)(]PLIIx MOVIE", "0604" => "Neo", 
				  "0605" => "STREAM DIRECT NORMAL Straight Decode", "0606" => "[)(]DIGITAL EX", 
				  "0607" => "[)(]PLIIx MOVIE", "0608" => "(nothing)", "0609" => "ES MATRIX", "060a" => "ES DISCRETE", 
				  "060b" => "DTS-ES 8ch", "060c" => "Neo", "060d" => "ES Neo", "0701" => "STREAM DIRECT PURE 2ch", 
				  "0702" => "[)(]PLII MOVIE", "0703" => "[)(]PLIIx MOVIE", "0704" => "Neo", 
				  "0705" => "STREAM DIRECT PURE Straight Decode", "0706" => "[)(]DIGITAL EX", 
				  "0707" => "[)(]PLIIx MOVIE", "0708" => "(nothing)", "0709" => "ES MATRIX", "070a" => "ES DISCRETE", 
				  "070b" => "DTS-ES 8ch", "070c" => "Neo", "070d" => "ES Neo", "0881" => "OPTIMUM", 
				  "0e01" => "HDMI THROUGH", "0f01" => "MULTI CH IN");
		If (array_key_exists($ListeningMode, $Mode)) {
			$ListingModeText = $Mode[$ListeningMode];
		}
		else {
			$ListingModeText = "Unbekannter Listening Mode!";
		}
		
	return $ListingModeText;
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
