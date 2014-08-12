<?php 
class fileupload {

    var $thefile;
	var $thetempfile;
    var $uploaddir;
	var $replace;
	var $dofilenamecheck;
	var $maxlengthfilename = 100;
    var $extensions;
	var $extstring;
	var $language;
	var $pagingType;
	var $httperror;
	var $message = array();
	
	function fileupload() {
		$this->message[] 	= $this->errortext(10);
		$this->httperror 	= 0;
		$this->replace 		= "y";
	}
	function errortext($errnum) {
		switch ($this->language) {
			case "de":
			break;
			default:
			$error[0] = "File: <b>".$this->thefile."</b> successfully uploaded!";
			$error[1] = "The uploaded file exceeds the max. upload filesize directive in the server configuration.";
			$error[2] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.";
			$error[3] = "The uploaded file was only partially uploaded";
			$error[4] = "No file was uploaded";
			$error[10] = "Please select a file for upload.";
			$error[11] = "Only files with the following extensions are allowed: <b>".$this->extstring."</b>";
			$error[12] = "Sorry, the filename contains invalid characters. Use only alphanumerical chars and separate parts of the name (if needed) with an underscore. A valid filename ends with one dot followed by the extension.";
			$error[13] = "The filename exceeds the maximum length of ".$this->maxlengthfilename." characters.";
			$error[14] = "Sorry, the upload directory doesn't exist!";
			$error[15] = "Uploading <b>".$this->thefile."...Error!</b> Sorry, a file with this name already exitst.";
			
		}
		return $error[$errnum];
	}
	function showerrorstring() {
		$msgstring = "";
		foreach ($this->message as $value) {
			$msgstring .= $value."<br>\n";
		}
		return $msgstring;
	}
	function upload() {
		if ($this->checkfilename()) {
			if ($this->validateExtension()) {				
				if (is_uploaded_file($this->thetempfile)) {							
					if ($this->moveupload($this->thetempfile, $this->thefile)) {					
					
						$this->message[] = $this->errortext($this->httperror);
						return true;
					}
				} else {
					$this->message[] = $this->errortext($this->httperror);
					return false;
				}
			} else {
				$this->showextensions();
				$this->message[] = $this->errortext(11);
				return false;
				
			}
		} else {
			return false;
		}
	}
	function checkfilename() {
		if ($this->thefile != "") {
			if (strlen($this->thefile) > $this->maxlengthfilename) {
				$this->message[] = $this->errortext(13);
				return false;
			} else {
				if ($this->dofilenamecheck == "y") {
					if (ereg("^[a-zA-z0-9_]*\.[a-zA-az]{3,4}$", $this->thefile)) {
						return true;
					} else {
						$this->message[] = $this->errortext(12);
						return false;
					}
				} else {
					return true;
				}
			}
		} else {
			$this->message[] = $this->errortext(10);
			return false;
		}
	}
	function validateExtension() { 
		$extension = strtolower(strrchr($this->thefile,"."));
		$extarray = $this->extensions;
		if (in_array($extension, $extarray)) { 
			return true;
		} else {
			return false;
		}
	}
	// this method is only used for detailed error reporting
	function showextensions() {
		$this->extstring = implode(" ", $this->extensions);
	}
	function moveupload() {
		umask(0);
		if ($this->existingfile()) {
			$newfile = $this->uploaddir.$this->thefile;
			if ($this->checkdir()) {
				if (move_uploaded_file($this->thetempfile, $newfile)) {
					if ($this->replace == "y") {
						system("chmod 0777 $newfile");
					} else {
						system("chmod 0755 $newfile");
					}
					return true;
				} else {
					return false;
				}
			} else {
				$this->message[] = $this->errortext(14);
				return false;
			}
		} else {
			$this->message[] = $this->errortext(15);
			return false;
		}
	}
	function checkdir() {
		if (!is_dir($this->uploaddir)) {
			return false;
		} else {
			return true;
		}
	}
	function existingfile() {
		if ($this->replace == "y") {
			return true;
		} else {
			if (file_exists($this->uploaddir.$this->thefile)) {
				return false;
			} else {
				return true;
			}
		}
	}
}
?>