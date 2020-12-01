<?
class IPS2PioneerBDP450 extends IPSModule
{
	private $Socket = false;
	
	// Überschreibt die interne IPS_Create($id) Funktion
        public function Create() 
        {
            	// Diese Zeile nicht löschen.
            	parent::Create();
		$this->RegisterPropertyBoolean("Open", false);
	    	$this->RegisterPropertyString("IPAddress", "127.0.0.1");
		$this->RegisterPropertyInteger("DataUpdate", 15);
		$this->RegisterTimer("DataUpdate", 0, 'I2BDP_Get_DataUpdate($_IPS["TARGET"]);');
		$this->RegisterPropertyBoolean("RC_Data", false);
		
		// Profile anlegen
		$this->RegisterProfileInteger("IPS2PioneerBDP450.Modus", "Information", "", "", 0, 11, 1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 0, "Tray opening completed", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 1, "Tray closing completed", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 2, "Disc Information loading", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 3, "Tray opening", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 4, "Play", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 5, "Still", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 6, "Pause", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 7, "Searching", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 8, "Forward/reverse scanning", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 9, "Forward/reverse slow play", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Modus", 10, "unbekannt", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2PioneerBDP450.Information", "Information", "", "", 0, 4, 1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Information", 0, "Bluray", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Information", 1, "DVD", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Information", 2, "CD", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Information", 3, "unbekannt", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2PioneerBDP450.Application", "Information", "", "", 0, 4, 1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 0, "BDMV", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 1, "BDAV", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 2, "DVD-Video", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 3, "DVD VR", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 4, "CD-DA", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 5, "DTS-CD", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.Application", 6, "unbekannt", "Information", -1);
		
		$this->RegisterProfileInteger("IPS2PioneerBDP450.DiscLoaded", "Information", "", "", 0, 4, 1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.DiscLoaded", 0, "Nein", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.DiscLoaded", 1, "Ja", "Information", -1);
		IPS_SetVariableProfileAssociation("IPS2PioneerBDP450.DiscLoaded", 2, "unbekannt", "Information", -1);
	
		
		$this->RegisterVariableString("PlayerModel", "PlayerModel", "", 5);
		$this->RegisterVariableString("PlayerFirmware", "PlayerFirmware", "", 7);
		
		$this->RegisterVariableBoolean("Power", "Power", "~Switch", 10);
		$this->EnableAction("Power");
		
		$this->RegisterVariableInteger("Modus", "Modus", "IPS2PioneerBDP450.Modus", 20);
		$this->RegisterVariableInteger("Chapter", "Chapter", "", 30);
		$this->RegisterVariableInteger("Time", "Time", "~UnixTimestampTime", 40);

		//$this->RegisterVariableString("StatusRequest", "StatusRequest", "", 50);
		//$this->DisableAction("StatusRequest");
		$this->RegisterVariableInteger("Track", "Track", "", 60);
		$this->RegisterVariableInteger("DiscLoaded", "DiscLoaded", "IPS2PioneerBDP450.DiscLoaded", 70);
		$this->RegisterVariableInteger("Application", "Application", "IPS2PioneerBDP450.Application", 80);
		$this->RegisterVariableInteger("Information", "Information", "IPS2PioneerBDP450.Information", 90);
		

		
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
 		$arrayElements[] = array("type" => "Label", "caption" => "_____________________________________________________________________________________________________");
				
		$arrayElements[] = array("type" => "Label", "caption" => "Zyklus Daten-Update in Sekunden (0 -> aus, 1 sek -> Minimum)");
		$arrayElements[] = array("type" => "IntervalBox", "name" => "DataUpdate", "caption" => "s");
		$arrayElements[] = array("type" => "Label", "caption" => "_____________________________________________________________________________________________________");
		$arrayElements[] = array("type" => "CheckBox", "name" => "RC_Data", "caption" => "Virtuelle Fernbedienung erstellen"); 
		$arrayElements[] = array("type" => "Label", "caption" => "_____________________________________________________________________________________________________");
		$arrayElements[] = array("type" => "Label", "caption" => "Test Center"); 
		$arrayElements[] = array("type" => "TestCenter", "name" => "TestCenter");
		
		return JSON_encode(array("status" => $arrayStatus, "elements" => $arrayElements)); 		 
 	} 
	
	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();
		
		$this->SetBuffer("LastCommand", "");
		$this->SetBuffer("LastCommandTimestamp", 0);
		$this->SetBuffer("LastResponseTimestamp", 0);
		$this->SetBuffer("TimeTrigger", "false");
		$this->SetBuffer("TriggerCounter", 0);
		
		If ($this->ReadPropertyBoolean("RC_Data") == true) {
			$this->RegisterVariableBoolean("rc_POWER", "POWER", "~Switch", 500);
			$this->EnableAction("rc_POWER");
			$this->RegisterVariableBoolean("rc_CONTINUED", "CONTINUED", "~Switch", 505);
			$this->EnableAction("rc_CONTINUED");
			$this->RegisterVariableBoolean("rc_OPEN_CLOSE", "OPEN/CLOSE", "~Switch", 510);
			$this->EnableAction("rc_OPEN_CLOSE");
			$this->RegisterVariableBoolean("rc_AUDIO", "AUDIO", "~Switch", 520);
			$this->EnableAction("rc_AUDIO");
			$this->RegisterVariableBoolean("rc_1", "1", "~Switch", 530);
			$this->EnableAction("rc_1");
			$this->RegisterVariableBoolean("rc_2", "2", "~Switch", 540);
			$this->EnableAction("rc_2");
			$this->RegisterVariableBoolean("rc_3", "3", "~Switch", 550);
			$this->EnableAction("rc_3");
			$this->RegisterVariableBoolean("rc_4", "4", "~Switch", 560);
			$this->EnableAction("rc_4");
			$this->RegisterVariableBoolean("rc_5", "5", "~Switch", 570);
			$this->EnableAction("rc_5");
			$this->RegisterVariableBoolean("rc_6", "6", "~Switch", 580);
			$this->EnableAction("rc_6");
			$this->RegisterVariableBoolean("rc_7", "7", "~Switch", 590);
			$this->EnableAction("rc_7");
			$this->RegisterVariableBoolean("rc_8", "8", "~Switch", 600);
			$this->EnableAction("rc_8");
			$this->RegisterVariableBoolean("rc_9", "9", "~Switch", 610);
			$this->EnableAction("rc_9");
			$this->RegisterVariableBoolean("rc_0", "0", "~Switch", 620);
			$this->EnableAction("rc_0");
			$this->RegisterVariableBoolean("rc_SUBTITLE", "SUBTITLE", "~Switch", 640);
			$this->EnableAction("rc_SUBTITLE");
			$this->RegisterVariableBoolean("rc_ANGLE", "ANGLE", "~Switch", 650);
			$this->EnableAction("rc_ANGLE");
			$this->RegisterVariableBoolean("rc_FL_DIMMER", "FL DIMMER", "~Switch", 660);
			$this->EnableAction("rc_FL_DIMMER");
			$this->RegisterVariableBoolean("rc_CD_SACD", "CD/SACD", "~Switch", 670);
			$this->EnableAction("rc_CD_SACD");
			$this->RegisterVariableBoolean("rc_HDMI", "HDMI", "~Switch", 680);
			$this->EnableAction("rc_HDMI");
			$this->RegisterVariableBoolean("rc_TOP_MENU", "TOP MENU", "~Switch", 690);
			$this->EnableAction("rc_TOP_MENU");
			$this->RegisterVariableBoolean("rc_FUNCTION", "FUNCTION", "~Switch", 700);
			$this->EnableAction("rc_FUNCTION");
			$this->RegisterVariableBoolean("rc_EXIT", "EXIT", "~Switch", 710);
			$this->EnableAction("rc_EXIT");
			$this->RegisterVariableBoolean("rc_HOME_MEDIA_GALLERY", "HOME MEDIA GALLERY", "~Switch", 720);
			$this->EnableAction("rc_HOME_MEDIA_GALLERY");
			$this->RegisterVariableBoolean("rc_POPUP_MENU", "POPUP MENU", "~Switch", 730);
			$this->EnableAction("rc_POPUP_MENU");
			$this->RegisterVariableBoolean("rc_UP", "UP", "~Switch", 740);
			$this->EnableAction("rc_UP");
			$this->RegisterVariableBoolean("rc_LEFT", "LEFT", "~Switch", 750);
			$this->EnableAction("rc_LEFT");
			$this->RegisterVariableBoolean("rc_ENTER", "ENTER", "~Switch", 760);
			$this->EnableAction("rc_ENTER");
			$this->RegisterVariableBoolean("rc_RIGHT", "RIGHT", "~Switch", 770);
			$this->EnableAction("rc_RIGHT");
			$this->RegisterVariableBoolean("rc_DOWN", "DOWN", "~Switch", 780);
			$this->EnableAction("rc_DOWN");
			$this->RegisterVariableBoolean("rc_HOME_MENU", "HOME MENU", "~Switch", 790);
			$this->EnableAction("rc_HOME_MENU");
			$this->RegisterVariableBoolean("rc_RETURN", "RETURN", "~Switch", 800);
			$this->EnableAction("rc_RETURN");
			$this->RegisterVariableBoolean("rc_COLOR_1", "COLOR 1 (PROGRAM)", "~Switch", 810);
			$this->EnableAction("rc_COLOR_1");
			$this->RegisterVariableBoolean("rc_COLOR_2", "COLOR 2 (BOOKMARK)", "~Switch", 800);
			$this->EnableAction("rc_COLOR_2");
			$this->RegisterVariableBoolean("rc_COLOR_3", "COLOR 3（ZOOM）", "~Switch", 810);
			$this->EnableAction("rc_COLOR_3");
			$this->RegisterVariableBoolean("rc_COLOR_4", "COLOR 4（INDEX）", "~Switch", 820);
			$this->EnableAction("rc_COLOR_4");
			$this->RegisterVariableBoolean("rc_REV_SCAN", "REV SCAN", "~Switch", 830);
			$this->EnableAction("rc_REV_SCAN");
			$this->RegisterVariableBoolean("rc_PLAY", "PLAY", "~Switch", 840);
			$this->EnableAction("rc_PLAY");
			$this->RegisterVariableBoolean("rc_FWD_SCAN", "FWD SCAN", "~Switch", 850);
			$this->EnableAction("rc_FWD_SCAN");
			$this->RegisterVariableBoolean("rc_PREV_STEP_SLOW", "PREV/STEP/SLOW", "~Switch", 860);
			$this->EnableAction("rc_PREV_STEP_SLOW");
			$this->RegisterVariableBoolean("rc_PAUSE", "PAUSE", "~Switch", 870);
			$this->EnableAction("rc_PAUSE");
			$this->RegisterVariableBoolean("rc_STOP", "STOP", "~Switch", 880);
			$this->EnableAction("rc_STOP");
			$this->RegisterVariableBoolean("rc_NEXT_STEP_SLOW", "NEXT/STEP/SLOW", "~Switch", 890);
			$this->EnableAction("rc_NEXT_STEP_SLOW");
			$this->RegisterVariableBoolean("rc_2nd_VIDEO", "2nd VIDEO", "~Switch", 900);
			$this->EnableAction("rc_2nd_VIDEO");
			$this->RegisterVariableBoolean("rc_2nd_AUDIO", "2nd AUDIO", "~Switch", 910);
			$this->EnableAction("rc_2nd_AUDIO");
			$this->RegisterVariableBoolean("rc_A_B", "A-B", "~Switch", 920);
			$this->EnableAction("rc_A_B");
			$this->RegisterVariableBoolean("rc_CLEAR", "CLEAR", "~Switch", 925);
			$this->EnableAction("rc_CLEAR");
			$this->RegisterVariableBoolean("rc_REPEAT", "REPEAT", "~Switch", 930);
			$this->EnableAction("rc_REPEAT");
			$this->RegisterVariableBoolean("rc_DISPLAY", "DISPLAY", "~Switch", 935);
			$this->EnableAction("rc_DISPLAY");
			$this->RegisterVariableBoolean("rc_KEYLOCK", "KEYLOCK", "~Switch", 940);
			$this->EnableAction("rc_KEYLOCK");
			$this->RegisterVariableBoolean("rc_REPLAY", "REPLAY", "~Switch", 945);
			$this->EnableAction("rc_REPLAY");
			$this->RegisterVariableBoolean("rc_SKIP_SEACH", "SKIP SEACH", "~Switch", 950);
			$this->EnableAction("rc_SKIP_SEACH");
			$this->RegisterVariableBoolean("rc_NET_FLIX", "NET FLIX", "~Switch", 955);
			$this->EnableAction("rc_NET_FLIX");
		}
		
		SetValueBoolean($this->GetIDForIdent("Power"), false);
		SetValueInteger($this->GetIDForIdent("Modus"), 10);
		SetValueInteger($this->GetIDForIdent("Chapter"), 0);
		//$Time = date('H:i:s', mktime(0, 0, 0, 0, 0, 0));
		$Time = mktime(0, 0, 0, 0, 0, 0);
		SetValueInteger($this->GetIDForIdent("Time"), $Time);
		SetValueInteger($this->GetIDForIdent("Track"), 0);
		SetValueInteger($this->GetIDForIdent("DiscLoaded"), 2);
		SetValueInteger($this->GetIDForIdent("Application"), 6);
		SetValueInteger($this->GetIDForIdent("Information"), 11);
		
		If (IPS_GetKernelRunlevel() == 10103) {
			If (($this->ReadPropertyBoolean("Open") == true) AND ($this->ConnectionTest() == true)) {
				$this->SetTimerInterval("DataUpdate", 1000);
				$this->SetStatus(102);
				// Erste Abfrage der Daten
				$this->CommandClientSocket("?P", 5);
			}
			else {
				$this->SetStatus(104);
			}	   
		}
	}
	
	public function RequestAction($Ident, $Value) 
	{
  		If ($this->ReadPropertyBoolean("Open") == true) {
			switch($Ident) {
				case "Power":
						$this->CommandClientSocket("/A181AFBC/RU", 3);			
					break;
				case "rc_POWER":
						$this->CommandClientSocket("/A181AFBC/RU", 3);				
					break;
				case "rc_CONTINUED":
						$this->CommandClientSocket("/A181AFAA/RU", 3);				
					break;
				case "rc_OPEN_CLOSE":
						$this->CommandClientSocket("/A181AFB6/RU", 3);				
					break;
				case "rc_AUDIO":
						$this->CommandClientSocket("/A181AFBE/RU", 3);
					break;
				case "rc_SUBTITLE":
						$this->CommandClientSocket("/A181AF36/RU", 3);
					break;
				case "rc_ANGLE":
						$this->CommandClientSocket("/A181AFB5/RU", 3);				
					break;
				case "rc_FL_DIMMER":
						$this->CommandClientSocket("/A181AFF9/RU", 3);				
					break;
				case "rc_CD_SACD":
						$this->CommandClientSocket("/A181AF2A/RU", 3);				
					break;
				case "rc_HDMI":
						$this->CommandClientSocket("/A181AFF8/RU", 3);				
					break;
				case "rc_TOP_MENU":
						$this->CommandClientSocket("/A181AFB4/RU", 3);				
					break;
				case "rc_FUNCTION":
						$this->CommandClientSocket("/A181AFB3/RU", 3);				
					break;
				case "rc_EXIT":
						$this->CommandClientSocket("/A181AF20/RU", 3);				
					break;
				case "rc_HOME_MEDIA_GALLERY":
						$this->CommandClientSocket("/A181AFF7/RU", 3);				
					break;
				case "rc_POPUP_MENU":
						$this->CommandClientSocket("/A181AFB9/RU", 3);				
					break;
				case "rc_UP":
						$this->CommandClientSocket("/A184FFFF/RU", 3);				
					break;
				case "rc_LEFT":
						$this->CommandClientSocket("/A187FFFF/RU", 3);				
					break;	
				case "rc_ENTER":
						$this->CommandClientSocket("/A181AFEF/RU", 3);				
					break;
				case "rc_RIGHT":
						$this->CommandClientSocket("/A186FFFF/RU", 3);				
					break;		
				case "rc_DOWN":
						$this->CommandClientSocket("/A185FFFF/RU", 3);				
					break;
				case "rc_HOME_MENU":
						$this->CommandClientSocket("/A181AFB0/RU", 3);				
					break;	
				case "rc_RETURN":
						$this->CommandClientSocket("/A181AFF4/RU", 3);				
					break;
				case "rc_COLOR_1":
						$this->CommandClientSocket("/A181AF60/RU", 3);				
					break;	
				case "rc_COLOR_2":
						$this->CommandClientSocket("/A181AF61/RU", 3);				
					break;
				case "rc_COLOR_3":
						$this->CommandClientSocket("/A181AF62/RU", 3);				
					break;		
				case "rc_COLOR_4":
						$this->CommandClientSocket("/A181AF63/RU", 3);				
					break;
				case "rc_REV_SCAN":
						$this->CommandClientSocket("/A181AFEA/RU", 3);				
					break;	
				case "rc_PLAY":
						$this->CommandClientSocket("/A181AF39/RU", 3);				
					break;
				case "rc_FWD_SCAN":
						$this->CommandClientSocket("/A181AFE9/RU", 3);				
					break;	
				case "rc_PREV_STEP_SLOW":
						$this->CommandClientSocket("/A181AF3E/RU", 3);				
					break;
				case "rc_PAUSE":
						$this->CommandClientSocket("/A181AF3A/RU", 3);				
					break;
				case "rc_STOP":
						$this->CommandClientSocket("/A181AF38/RU", 3);				
					break;
				case "rc_NEXT_STEP_SLOW":
						$this->CommandClientSocket("/A181AF3D/RU", 3);				
					break;	
				case "rc_1":
						$this->CommandClientSocket("/A181AFA1/RU", 3);				
					break;
				case "rc_2":
						$this->CommandClientSocket("/A181AFA2/RU", 3);				
					break;
				case "rc_3":
						$this->CommandClientSocket("/A181AFA3/RU", 3);				
					break;
				case "rc_4":
						$this->CommandClientSocket("/A181AFA4/RU", 3);				
					break;
				case "rc_5":
						$this->CommandClientSocket("/A181AFA5/RU", 3);				
					break;
				case "rc_6":
						$this->CommandClientSocket("/A181AFA6/RU", 3);				
					break;
				case "rc_7":
						$this->CommandClientSocket("/A181AFA7/RU", 3);				
					break;
				case "rc_8":
						$this->CommandClientSocket("/A181AFA8/RU", 3);				
					break;
				case "rc_9":
						$this->CommandClientSocket("/A181AFA9/RU", 3);				
					break;
				case "rc_0":
						$this->CommandClientSocket("/A181AFA0/RU", 3);				
					break;
				case "rc_2nd_VIDEO":
						$this->CommandClientSocket("/A181AFBF/RU", 3);				
					break;
				case "rc_2nd_AUDIO":
						$this->CommandClientSocket("/A181AFBD/RU", 3);				
					break;
				case "rc_A_B":
						$this->CommandClientSocket("/A181AFE4/RU", 3);				
					break;
				case "rc_CLEAR":
						$this->CommandClientSocket("/A181AFE5/RU", 3);				
					break;	
				case "rc_REPEAT":
						$this->CommandClientSocket("/A181AFE8/RU", 3);				
					break;
				case "rc_DISPLAY":
						$this->CommandClientSocket("/A181AFE3/RU", 3);				
					break;
				case "rc_KEYLOCK":
						$this->CommandClientSocket("/A181AF22/RU", 3);				
					break;
				case "rc_REPLAY":
						$this->CommandClientSocket("/A181AF24/RU", 3);				
					break;	
				case "rc_SKIP_SEACH":
						$this->CommandClientSocket("/A181AF25/RU", 3);				
					break;
				case "rc_NET_FLIX":
						$this->CommandClientSocket("/A181AF6A/RU", 3);				
					break;	
				default:
				    throw new Exception("Invalid Ident");
			}
		}
		$this->Get_DataUpdate();
	}
	
	public function Get_DataUpdate()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->SetBuffer("TriggerCounter", $this->GetBuffer("TriggerCounter") + 1); 
			If ( ($this->GetBuffer("TimeTrigger") == "true") AND ($this->GetBuffer("TriggerCounter") <> $this->ReadPropertyInteger("DataUpdate") ) ) {
				// Spielt das Gerät ein Medium wird jede Sekunde die aktuelle Spielzeit abgefragt
				$this->CommandClientSocket("?T", 6);
			}
			elseif ($this->GetBuffer("TriggerCounter") == $this->ReadPropertyInteger("DataUpdate")) {	
				$this->SetBuffer("TriggerCounter", 0); 
				// Power-Status abfragen
				$this->CommandClientSocket("?P", 5);
			}
		}
	}
	
	private function CommandClientSocket(String $Message, $ResponseLen = 3)
	{
		$Result = -999;
		If ($this->ReadPropertyBoolean("Open") == true) {
			if (!$this->Socket)
			{
				// Socket erstellen
				if(!($this->Socket = socket_create(AF_INET, SOCK_STREAM, 0))) {
					$errorcode = socket_last_error();
					$errormsg = socket_strerror($errorcode);
					$this->SendDebug("CommandClientSocket", "Fehler beim Erstellen ".$errorcode." ".$errormsg, 0);
					IPS_SemaphoreLeave("ClientSocket");
					return;
				}
				// Timeout setzen
				socket_set_option($this->Socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>2, "usec"=>0));
				// Verbindung aufbauen
				if(!(socket_connect($this->Socket, $this->ReadPropertyString("IPAddress"), 8102))) {
					$errorcode = socket_last_error();
					$errormsg = socket_strerror($errorcode);
					$this->SendDebug("CommandClientSocket", "Fehler beim Verbindungsaufbaus ".$errorcode." ".$errormsg, 0);
					IPS_SemaphoreLeave("ClientSocket");
					return;
				}
				if (!$this->Socket) {
					IPS_LogMessage("PioneerBDP450 Socket", "Fehler beim Verbindungsaufbau ".$errno." ".$errstr);
					$this->SendDebug("CommandClientSocket", "Fehler beim Verbindungsaufbau ".$errno." ".$errstr, 0);
					IPS_SemaphoreLeave("ClientSocket");
					return $Result;
				}
			}
			// Message senden
			if(!socket_send ($this->Socket, $Message.chr(13), strlen($Message.chr(13)), 0))
			{
				$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
				IPS_LogMessage("PioneerBDP450 Socket", "Fehler beim Senden ".$errorcode." ".$errormsg);
				$this->SendDebug("CommandClientSocket", "Fehler beim Senden ".$errorcode." ".$errormsg, 0);
				IPS_SemaphoreLeave("ClientSocket");
				return;
			}
			//Now receive reply from server
			if(socket_recv ($this->Socket, $Response, $ResponseLen, MSG_WAITALL ) === FALSE) {
				$errorcode = socket_last_error();
				$errormsg = socket_strerror($errorcode);
				IPS_LogMessage("PioneerBDP450 Socket", "Fehler beim Empfangen ".$errorcode." ".$errormsg);
				$this->SendDebug("CommandClientSocket", "Fehler beim Empfangen ".$errorcode." ".$errormsg, 0);
				$this->SendDebug("CommandClientSocket", "Gesendeter Befehl: ".$Message, 0);
				IPS_SemaphoreLeave("ClientSocket");
				return;
			}

			$this->SendDebug("CommandClientSocket", "Message: ".$Message." Rueckgabe: ".$Response, 0);
			$this->ClientResponse($Message, $Response);
		}	
	return $Result;
	}
	
	private function ClientResponse($Message, $Response) 
	{
		// Entfernen der Steuerzeichen
		$Response = trim($Response, "\x00..\x1F");
		
		switch($Message) {
			case "?P":
				If ($Message == "E04") { 
					If(GetValueBoolean($this->GetIDForIdent("Power")) == true) {
						// Gerät ist ausgeschaltet
						$this->SetBuffer("TimeTrigger", "false");
						SetValueBoolean($this->GetIDForIdent("Power"), false);
						SetValueInteger($this->GetIDForIdent("Modus"), 10);
						SetValueInteger($this->GetIDForIdent("Chapter"), 0);
						//$Time = date('H:i:s', mktime(0, 0, 0, 0, 0, 0));
						$Time = mktime(0, 0, 0, 0, 0, 0);
						SetValueInteger($this->GetIDForIdent("Time"), $Time);
						//SetValueString($this->GetIDForIdent("StatusRequest"), "");
						SetValueInteger($this->GetIDForIdent("Track"), 0);
						SetValueInteger($this->GetIDForIdent("DiscLoaded"), 2);
						SetValueInteger($this->GetIDForIdent("Application"), 6);
						SetValueInteger($this->GetIDForIdent("Information"), 11);
					}
				}
				else {
					// Gerät ist eingeschaltet
					SetValueBoolean($this->GetIDForIdent("Power"), true);
					If (GetValueString($this->GetIDForIdent("PlayerModel")) == "") {
						// PlayerModel ermitteln
						$this->CommandClientSocket("?L", 7);
					}
					else {
						SetValueInteger($this->GetIDForIdent("Modus"), intval(substr($Message, 1, 2)));
						// Prüfen ob eine Disk im Laufwerk ist
						$this->CommandClientSocket("?D", 5);
					}
				}
				break;
			case "?D":
				If (substr($Message, 0, 1) == "x") {
					SetValueInteger($this->GetIDForIdent("DiscLoaded"), 2);
					$this->SetBuffer("TimeTrigger", "false");
				}
				elseif (substr($Message, 0, 1) == "0") {
					SetValueInteger($this->GetIDForIdent("DiscLoaded"), 0);
					$this->SetBuffer("TimeTrigger", "false");
				}
				elseif (substr($Message, 0, 1) == "1") {
					SetValueInteger($this->GetIDForIdent("DiscLoaded"), 1);
					// Abfrage des Mediums
					If (substr($Message, 1, 1) == "x") {
						SetValueString($this->GetIDForIdent("Information"),"No Disc");
						$this->SetBuffer("Information", 3);
						$this->SetBuffer("TimeTrigger", "false");
					}
					else {
						SetValueInteger($this->GetIDForIdent("Information"), intval(substr($Message, 1, 1)));
						$this->SetBuffer("Information", (int)substr($Message, 1, 1));
					}
					// Abfrage der Anwendung
					If (substr($Message, 2, 1) == "x") {
						SetValueInteger($this->GetIDForIdent("Application"), 6);
					}
					else {
						SetValueInteger($this->GetIDForIdent("Application"), intval(substr($Message, 2, 1)));
					}
					//IPS_LogMessage("IPS2PioneerBDP450","Information: ".$this->GetBuffer("Information"));
					
					If ( intval($this->GetBuffer("Information")) <> 3) {
						// Abfrage des Chapters
						$this->CommandClientSocket("?C", 3);
					}
				}
				break;
			case "?C":
				SetValueInteger($this->GetIDForIdent("Chapter"), intval($Message));
				// Titel/Track Nummer
				$this->CommandClientSocket("?R", 3);
				break;
			
			case "?R":
				SetValueInteger($this->GetIDForIdent("Track"), intval($Message));
					// Abfrage der Zeit
					$this->SetBuffer("TimeTrigger", "true");
					//$this->ClientSocket("?T".chr(13));
					//$this->ResponseWait();
					/*
					If ((int)$this->GetBuffer("Information") == 0) {
						// Bei Bluray
						$this->ClientSocket("?I".chr(13));
						$this->ResponseWait();
					}
					elseif ((int)$this->GetBuffer("Information") == 1) {
						// Bei DVD
						$this->ClientSocket("?V".chr(13));
						$this->ResponseWait();
					}
					elseif ((int)$this->GetBuffer("Information") == 2) {
						// Bei CD
						$this->ClientSocket("?K".chr(13));
						$this->ResponseWait();
					}
					*/
				break;
			case "?T":
				$Message = str_pad((string)$Message, 6 ,'0', STR_PAD_LEFT);
				//$this->SetBuffer("TimeTrigger", "true");
				$Hour = intval(substr($Message, 0, 2));
				$Minute = intval(substr($Message, 2, 2));
				$Second = intval(substr($Message, 4, 2));
				//$Time = date('H:i:s', mktime($Hour, $Minute, $Second, 0, 0, 0));
				$Time = mktime($Hour, $Minute, $Second, 0, 0, 0);
				SetValueInteger($this->GetIDForIdent("Time"), $Time);
				break;
			case "?V":
				//SetValueString($this->GetIDForIdent("StatusRequest"), (string)$Message);	
				break;
			case "?I":
				//SetValueString($this->GetIDForIdent("StatusRequest"), (string)$Message);	
				break;
			case "?K":
				//SetValueString($this->GetIDForIdent("StatusRequest"), (string)$Message);	
				break;
			case "?L":
				SetValueString($this->GetIDForIdent("PlayerModel"), (string)$Message);
				// Firmware abfragen
				$this->CommandClientSocket("?Z", 6);
				break;
			case "?Z":
				SetValueString($this->GetIDForIdent("PlayerFirmware"), (string)$Message);
				break;
		}
	}
	
	public function PowerOn()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("PN", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function PowerOff()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("PF", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function Open()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("OP", 5);
			$this->Get_DataUpdate();
		}
	}
	
	public function Close()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("CO", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function Stop()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("99RJ", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function Play()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("PL", 5);
			$this->Get_DataUpdate();
		}
	}
	
	public function Still()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("ST", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function StepForward()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("SF", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function StepReverse()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("SR", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function StopScan()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("NS", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function ScanForward()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("NF", 5);
			$this->Get_DataUpdate();
		}	
	}
	
	public function ScanReverse()
	{
		If ($this->ReadPropertyBoolean("Open") == true) {
			$this->CommandClientSocket("NR", 5);
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
	
}
?>
