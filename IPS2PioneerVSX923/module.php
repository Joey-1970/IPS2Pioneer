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
		
		// Profile anlegen
		$this->RegisterProfileFloat("IPS2Pioneer.dB", "Melody", "", " dB", -80, 12, 0.5, 1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.BassTreble", "Music", "", " dB", -6, 6, 1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.Volume", "Shutter", "", "", 0, 1, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Volume", 0, "+", "Shutter", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Volume", 1, "-", "Shutter", -1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.Input", "Repeat", "", "", 0, 1, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Input", 0, "<", "Repeat", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Input", 1, ">", "Repeat", -1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.Speaker", "Speaker", "", "", 0, 3, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Speaker", 0, "Speaker off", "Speaker", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Speaker", 1, "Speaker A on", "Speaker", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Speaker", 2, "Speaker B on", "Speaker", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Speaker", 3, "Speaker A+B on", "Speaker", -1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.Tone", "Music", "", "", 0, 1, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Tone", 0, "ByPass", "Music", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.Tone", 1, "On", "Music", -1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.HDMIOut", "TV", "", "", 0, 2, 0);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.HDMIOut", 0, "HDMI Out All", "TV", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.HDMIOut", 1, "HDMI Out 1", "TV", -1);
		IPS_SetVariableProfileAssociation("IPS2Pioneer.HDMIOut", 2, "HDMI Out 2", "TV", -1);
		
		$this->RegisterProfileInteger("IPS2Pioneer.ListeningModeSet", "Melody", "", "", 0, 128, 0);
		$this->SetListeningMode();
		
		$MetadataArray = array(1 => "", 2 => "", 3 => "", 4 => "", 5 => "", 6 => "", 7 => "", 8 => "");
		$this->SetBuffer("Metadata", serialize($MetadataArray));
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
		$this->RegisterMediaObject("Cover", "Cover_".$this->InstanceID, 1, $this->InstanceID, 1000, true, "Cover.jpg");

		
		
		// Profile anlegen
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
		
		$this->RegisterVariableInteger("InputChange", "Input", "IPS2Pioneer.Input", 40);
		$this->EnableAction("InputChange");
		
		$this->RegisterVariableFloat("Volume", "Volume", "IPS2Pioneer.dB", 50);
		$this->EnableAction("Volume");
		
		$this->RegisterVariableInteger("VolumeUpDown", "Volume", "IPS2Pioneer.Volume", 60);
		$this->EnableAction("VolumeUpDown");
		
		$this->RegisterVariableString("Display", "Display", "", 70);
		
		$this->RegisterVariableString("ListeningMode", "Listening Mode", "", 80);
		
		$this->RegisterVariableInteger("ListeningModeSet", "Listening Mode", "IPS2Pioneer.ListeningModeSet", 90);
		$this->EnableAction("ListeningModeSet");
		
		$this->RegisterVariableBoolean("Mute", "Mute", "~Switch", 100);
		$this->EnableAction("Mute");
		
		$this->RegisterVariableInteger("Speakers", "Speakers", "IPS2Pioneer.Speaker", 110);
		$this->EnableAction("Speakers");
		
		$this->RegisterVariableInteger("Tone", "Tone", "IPS2Pioneer.Tone", 120);
		$this->EnableAction("Tone");
		
		$this->RegisterVariableInteger("Bass", "Bass", "IPS2Pioneer.BassTreble", 130);
		$this->EnableAction("Bass");
		
		$this->RegisterVariableInteger("Treble", "Treble", "IPS2Pioneer.BassTreble", 140);
		$this->EnableAction("Treble");
		
		$this->RegisterVariableString("Metadata", "Metadata", "~TextBox", 150);
		
		$this->RegisterVariableBoolean("Zone_2", "Zone_2", "~Switch", 160);
		$this->EnableAction("Zone_2");
		
		$this->RegisterVariableInteger("Zone_2_Source", "Zone 2 Source", "IPS2Pioneer.InputSelect_".$this->InstanceID, 165);
		$this->EnableAction("Zone_2_Source");
		
		$this->RegisterVariableBoolean("Zone_3", "Zone_3", "~Switch", 170);
		$this->EnableAction("Zone_3");
		
		$this->RegisterVariableInteger("Zone_3_Source", "Zone 3 Source", "IPS2Pioneer.InputSelect_".$this->InstanceID, 175);
		$this->EnableAction("Zone_3_Source");
		
		$this->RegisterVariableBoolean("Zone_4", "Zone_4", "~Switch", 180);
		$this->EnableAction("Zone_4");
		
		$this->RegisterVariableInteger("Zone_4_Source", "Zone 4 Source", "IPS2Pioneer.InputSelect_".$this->InstanceID, 185);
		$this->EnableAction("Zone_4_Source");
		
		$this->RegisterVariableInteger("HDMIOut", "HDMI Out", "IPS2Pioneer.HDMIOut", 190);
		$this->EnableAction("HDMIOut");
		
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
				$this->SetMetadata();
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
		
		$MessageParts = explode(chr(13), $Message);
		If (count($MessageParts) > 1) {
			$this->SendDebug("ReceiveData", "Messageparts: ".count($MessageParts), 0);
		}
		
		foreach ($MessageParts as $Message) {
			// Entfernen der Steuerzeichen
			$Message = trim($Message, "\x00..\x1F");
			$this->SendDebug("ReceiveData", $Message, 0);
		
			switch($Message) {
				case "E02":
					$this->SendDebug("ReceiveData", "E02: NOT AVAILABLE NOW", 0);
					break;
				case "E03":
					$this->SendDebug("ReceiveData", "E03: INVALID COMMAND", 0);
					break;
				case "E04":
					$this->SendDebug("ReceiveData", "E04: COMMAND ERROR", 0);
					break;
				case "E06":
					$this->SendDebug("ReceiveData", "E06: PARAMETER ERROR", 0);
					break;
				case "B00":
					$this->SendDebug("ReceiveData", "B00: BUSY", 0);
					break;
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
				case preg_match('/Z2F.*/', $Message) ? $Message : !$Message:
					SetValueInteger($this->GetIDForIdent("Zone_2_Source"), intval(substr($Message, -2)));
					break;
				case preg_match('/Z3F.*/', $Message) ? $Message : !$Message:
					SetValueInteger($this->GetIDForIdent("Zone_3_Source"), intval(substr($Message, -2)));
					break;
				case preg_match('/ZEA.*/', $Message) ? $Message : !$Message:
					SetValueInteger($this->GetIDForIdent("Zone_4_Source"), intval(substr($Message, -2)));
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
				case preg_match('/LM.*/', $Message) ? $Message : !$Message:
					$Mode = substr($Message, -4);
					$ModeText = $this->GetListeningMode($Mode);
					SetValueString($this->GetIDForIdent("ListeningMode"), $ModeText);
					break;
				case preg_match('/SR.*/', $Message) ? $Message : !$Message:
					$ListenningMode = intval(substr($Message, -4));
					SetValueInteger($this->GetIDForIdent("ListeningModeSet"), $ListenningMode);
					break;	
				case preg_match('/SPK.*/', $Message) ? $Message : !$Message:
					$Speaker = intval(substr($Message, -1));
					SetValueInteger($this->GetIDForIdent("Speakers"), $Speaker);
					break;	
				case preg_match('/HO.*/', $Message) ? $Message : !$Message:
					$HDMIOut = intval(substr($Message, -1));
					SetValueInteger($this->GetIDForIdent("HDMIOut"), $HDMIOut);
					break;	
				case preg_match('/TO.*/', $Message) ? $Message : !$Message:
					$ToneByPass = intval(substr($Message, -1));
					// Eventuell sperren von Bass und Treble???
					SetValueInteger($this->GetIDForIdent("Tone"), $ToneByPass);
					break;	
				case preg_match('/BA.*/', $Message) ? $Message : !$Message:
					$Bass = intval(substr($Message, -2)) - 6;
					SetValueInteger($this->GetIDForIdent("Bass"), $Bass);
					break;	
				case preg_match('/TR.*/', $Message) ? $Message : !$Message:
					$Treble = intval(substr($Message, -2)) - 6;
					SetValueInteger($this->GetIDForIdent("Treble"), $Treble);
					break;	
				case preg_match('/GIC.*/', $Message) ? $Message : !$Message:
					preg_match('/"([^"]*)"/is', $Message, $Result);
					$this->GetCover($Result[1]);
					break;	
				case preg_match('/GEH.*/', $Message) ? $Message : !$Message:
					$MetadataArray = unserialize($this->GetBuffer("Metadata"));
					$Line = intval(substr($Message, 3, 2));
					$FocusInformation = intval(substr($Message, 5, 1));
					$DataType = intval(substr($Message, 6, 2));
					preg_match('/"([^"]*)"/is', $Message, $Result);
					$Text = $Result[1];
					$MetadataArray[$Line] = $Text;
					$this->SetBuffer("Metadata", serialize($MetadataArray));
					$this->SetMetadata();
					break;
				case "APR0":
					SetValueBoolean($this->GetIDForIdent("Zone_2"), true);
					break;
				case "APR1":
					SetValueBoolean($this->GetIDForIdent("Zone_2"), false);
					break;
				case "BPR0":
					SetValueBoolean($this->GetIDForIdent("Zone_3"), true);
					break;
				case "BPR1":
					SetValueBoolean($this->GetIDForIdent("Zone_3"), false);
					break;
				case "ZEP0":
					SetValueBoolean($this->GetIDForIdent("Zone_4"), true);
					break;
				case "ZEP1":
					SetValueBoolean($this->GetIDForIdent("Zone_4"), false);
					break;
			}
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
				case "Zone_2_Source":
					SetValueInteger($this->GetIDForIdent("Zone_2_Source"), $Value);
					$Zone_2_Source = str_pad($Value, 2, '0', STR_PAD_LEFT);
					$this->SetData($Zone_2_Source."ZS");
					break;
				case "Zone_3_Source":
					SetValueInteger($this->GetIDForIdent("Zone_3_Source"), $Value);
					$Zone_3_Source = str_pad($Value, 2, '0', STR_PAD_LEFT);
					$this->SetData($Zone_3_Source."ZT");
					break;
				case "Zone_4_Source":
					SetValueInteger($this->GetIDForIdent("Zone_4_Source"), $Value);
					$Zone_4_Source = str_pad($Value, 2, '0', STR_PAD_LEFT);
					$this->SetData($Zone_4_Source."ZEA");
					break;
				case "ListeningModeSet":
					SetValueInteger($this->GetIDForIdent("ListeningModeSet"), $Value);
					$ListeningMode = str_pad($Value, 4, '0', STR_PAD_LEFT);
					$this->SetData($ListeningMode."SR");
					break;
				case "Speakers":
					SetValueInteger($this->GetIDForIdent("Speakers"), $Value);
					$Speaker = intval($Value);
					$this->SetData($Speaker."SPK");
					break;
				case "HDMIOut":
					SetValueInteger($this->GetIDForIdent("HDMIOut"), $Value);
					$HDMIOut = intval($Value);
					$this->SetData($HDMIOut."HO");
					break;
				case "Tone":
					SetValueInteger($this->GetIDForIdent("Tone"), $Value);
					$Tone = intval($Value);
					$this->SetData($Tone."TO");
					break;
				case "Bass":
					SetValueInteger($this->GetIDForIdent("Bass"), $Value);
					$Bass = intval($Value) + 6;
					$Bass = str_pad($Bass, 2, '0', STR_PAD_LEFT);
					$this->SetData($Bass."BA");
					break;
				case "Treble":
					SetValueInteger($this->GetIDForIdent("Treble"), $Value);
					$Treble = intval($Value) + 6;
					$Treble = str_pad($Treble, 2, '0', STR_PAD_LEFT);
					$this->SetData($Treble."TR");
					break;
				case "Zone_2":
					SetValueBoolean($this->GetIDForIdent("Zone_2"), $Value);
					If ($Value == true) {
						$this->SetData("APO");
					}
					else {
						$this->SetData("APF");
					}
					break;
				case "Zone_3":
					SetValueBoolean($this->GetIDForIdent("Zone_3"), $Value);
					If ($Value == true) {
						$this->SetData("BPO");
					}
					else {
						$this->SetData("BPF");
					}
					break;
				case "Zone_4":
					SetValueBoolean($this->GetIDForIdent("Zone_4"), $Value);
					If ($Value == true) {
						$this->SetData("ZEO");
					}
					else {
						$this->SetData("ZEZ");
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
			$MessageArray = array("?P", "?F", "?V", "?FL", "?M", "?L", "?S", "?SPK", "?TO", "?BA", "?TR", "?GIC", "?AP", "?BP", "?ZEP", "?HO", "?ZS", "?ZT", "?ZEA");
			foreach ($MessageArray as $Value) {
				$Message = $Value.chr(13);
				$Result = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => utf8_encode($Message))));
				IPS_Sleep(100);
			}
			//set_include_path(__DIR__.'/../imgs');
			$Content = file_get_contents(__DIR__ . '/../imgs/Pioneer.jpg');
			IPS_SetMediaContent($this->GetIDForIdent("Cover_".$this->InstanceID), base64_encode($Content));  //Bild Base64 codieren und ablegen
			IPS_SendMediaEvent($this->GetIDForIdent("Cover_".$this->InstanceID)); //aktualisieren
		}
	}
	
	private function SetData(String $Message)
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SendDebug("SetData", "Message: ".$Message, 0);
			$Message = $Message.chr(13);
			$Result = $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => utf8_encode($Message))));
		}
	}
	
	private function GetCover(String $URL = null)
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			if ($URL != null) { 
              			$Content = file_get_contents($URL); 
          		} else { 
              			$Content = file_get_contents(__DIR__ . '/../imgs/Pioneer.jpg'); 
          		} 

			IPS_SetMediaContent($this->GetIDForIdent("Cover_".$this->InstanceID), base64_encode($Content));  //Bild Base64 codieren und ablegen
			IPS_SendMediaEvent($this->GetIDForIdent("Cover_".$this->InstanceID)); //aktualisieren
		}
	} 
	
	private function SetMetadata()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$MetadataArray = unserialize($this->GetBuffer("Metadata"));
			$Value = "";
			for ($i = 1; $i <= 8; $i++) {
				$Value = $Value.$MetadataArray[$i].chr(13);
			}
			SetValueString($this->GetIDForIdent("Metadata"), $Value);
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
	
	private function SetListeningMode()
	{
		$Mode = array(1 => "STEREO (cyclic)", 10 => "STANDARD", 9 => "STEREO (direct set)", 11 => "(2ch source)", 
			      13 => "PRO LOGIC2 MOVIE", 18 => "PRO LOGIC2x MOVIE", 14 => "PRO LOGIC2 MUSIC", 19 => "PRO LOGIC2x MUSIC", 
			      15 => "PRO LOGIC2 GAME", 20 => "PRO LOGIC2x GAME", 31 => "PRO LOGIC2z HEIGHT", 32 => "WIDE SURROUND MOVIE", 
			      33 => "WIDE SURROUND MUSIC", 12 => "PRO LOGIC", 16 => "Neo", 17 => "Neo", 28 => "XM HD SURROUND", 
			      29 => "NEURAL SURROUND", 37 => "Neo", 38 => "Neo", 39 => "Neo", 40 => "NEURAL SURROUND+Neo", 
			      41 => "NEURAL SURROUND+Neo", 42 => "NEURAL SURROUND+Neo", 21 => "(Multi ch source)", 
			      22 => "(Multi ch source)+DOLBY EX", 23 => "(Multi ch source)+PRO LOGIC2x MOVIE", 
			      24 => "(Multi ch source)+PRO LOGIC2x MUSIC", 34 => "(Multi-ch Source)+PRO LOGIC2z HEIGHT", 
			      35 => "(Multi-ch Source)+WIDE SURROUND MOVIE", 36 => "(Multi-ch Source)+WIDE SURROUND MUSIC", 
			      25 => "(Multi ch source)DTS-ES Neo", 26 => "(Multi ch source)DTS-ES matrix", 
			      27 => "(Multi ch source)DTS-ES discrete", 30 => "(Multi ch source)DTS-ES 8ch discrete", 
			      43 => "(Multi ch source)+Neo", 44 => "(Multi ch source)+Neo", 45 => "(Multi ch source)+Neo", 
			      100 => "ADVANCED SURROUND (cyclic)", 101 => "ACTION", 103 => "DRAMA", 102 => "SCI-FI", 105 => "MONO FILM", 
			      104 => "ENTERTAINMENT SHOW", 106 => "EXPANDED THEATER", 116 => "TV SURROUND", 118 => "ADVANCED GAME", 
			      117 => "SPORTS", 107 => "CLASSICAL", 110 => "ROCK/POP", 109 => "UNPLUGGED", 112 => "EXTENDED STEREO", 
			      3 => "Front Stage Surround Advance Focus", 4 => "Front Stage Surround Advance Wide", 153 => "RETRIEVER AIR", 
			      113 => "PHONES SURROUND", 50 => "THX (cyclic)", 51 => "PROLOGIC + THX CINEMA", 52 => "PL2 MOVIE + THX CINEMA", 
			      53 => "Neo", 54 => "PL2x MOVIE + THX CINEMA", 92 => "PL2z HEIGHT + THX CINEMA", 55 => "THX SELECT2 GAMES", 
			      68 => "THX CINEMA (for 2ch)", 69 => "THX MUSIC (for 2ch)", 70 => "THX GAMES (for 2ch)", 
			      71 => "PL2 MUSIC + THX MUSIC", 72 => "PL2x MUSIC + THX MUSIC", 93 => "PL2z HEIGHT + THX MUSIC", 
			      73 => "Neo", 74 => "PL2 GAME + THX GAMES", 75 => "PL2x GAME + THX GAMES", 94 => "PL2z HEIGHT + THX GAMES", 
			      76 => "THX ULTRA2 GAMES", 77 => "PROLOGIC + THX MUSIC", 78 => "PROLOGIC + THX GAMES", 201 => "Neo", 
			      202 => "Neo", 203 => "Neo", 56 => "THX CINEMA (for multi ch)", 57 => "THX SURROUND EX (for multi ch)", 
			      58 => "PL2x MOVIE + THX CINEMA (for multi ch)", 95 => "PL2z HEIGHT + THX CINEMA (for multi ch)", 
			      59 => "ES Neo", 60 => "ES MATRIX + THX CINEMA (for multi ch)", 61 => "ES DISCRETE + THX CINEMA (for multi ch)", 
			      67 => "ES 8ch DISCRETE + THX CINEMA (for multi ch)", 62 => "THX SELECT2 CINEMA (for multi ch)", 
			      63 => "THX SELECT2 MUSIC (for multi ch)", 64 => "THX SELECT2 GAMES (for multi ch)", 
			      65 => "THX ULTRA2 CINEMA (for multi ch)", 66 => "THX ULTRA2 MUSIC (for multi ch)", 
			      79 => "THX ULTRA2 GAMES (for multi ch)", 80 => "THX MUSIC (for multi ch)", 
			      81 => "THX GAMES (for multi ch)", 82 => "PL2x MUSIC + THX MUSIC (for multi ch)", 
			      96 => "PL2z HEIGHT + THX MUSIC (for multi ch)", 83 => "EX + THX GAMES (for multi ch)", 
			      97 => "PL2z HEIGHT + THX GAMES (for multi ch)", 84 => "Neo", 85 => "Neo", 
			      86 => "ES MATRIX + THX MUSIC (for multi ch)", 87 => "ES MATRIX + THX GAMES (for multi ch)", 
			      88 => "ES DISCRETE + THX MUSIC (for multi ch)", 89 => "ES DISCRETE + THX GAMES (for multi ch)", 
			      90 => "ES 8CH DISCRETE + THX MUSIC (for multi ch)", 91 => "ES 8CH DISCRETE + THX GAMES (for multi ch)", 
			      204 => "Neo", 205 => "Neo", 206 => "Neo", 5 => "AUTO SURR/STREAM DIRECT (cyclic)", 6 => "AUTO SURROUND", 
			      151 => "Auto Level Control (A.L.C.)", 7 => "DIRECT", 8 => "PURE DIRECT", 152 => "OPTIMUM SURROUND");
		foreach ($Mode as $Key => $Value) {
			IPS_SetVariableProfileAssociation("IPS2Pioneer.ListeningModeSet", $Key, $Value, "Melody", -1);
		}
	return;
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
	
	private function RegisterMediaObject($Name, $Ident, $Typ, $Parent, $Position, $Cached, $Filename)
	{
		$MediaID = @$this->GetIDForIdent($Ident);
		if($MediaID === false) {
		    	$MediaID = 0;
		}
		
		if ($MediaID == 0) {
			 // Image im MedienPool anlegen
			$MediaID = IPS_CreateMedia($Typ); 
			// Medienobjekt einsortieren unter Kategorie $catid
			IPS_SetParent($MediaID, $Parent);
			IPS_SetIdent($MediaID, $Ident);
			IPS_SetName($MediaID, $Name);
			IPS_SetPosition($MediaID, $Position);
                    	IPS_SetMediaCached($MediaID, $Cached);
			$ImageFile = IPS_GetKernelDir()."media".DIRECTORY_SEPARATOR.$Filename;  // Image-Datei
			IPS_SetMediaFile($MediaID, $ImageFile, false);    // Image im MedienPool mit Image-Datei verbinden
		}  
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
