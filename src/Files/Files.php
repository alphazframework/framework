<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Files;

use Config\Config;

class Files
{
    //Declare Vars

    //Getting server operating system name. //$this->ServerOS
    private static $ServerOS = PHP_OS;

    //File Upload Max Size //$this->fupmaxs
    private static $fupmaxs = 7992000000;

    private static $fullDirPath;
    //Class Error Codes //$this->cecodes['']
    private static $cecodes = [
        'No_Support'    => '[Error]: File Type Not Supported ',
        'Cant_Create'   => '[Error]: Can\'t Create ',
        'No_Support_OS' => '[Error]: Sorry! Your Operating System Does Not Support The Command ',
        'Size_Limit'    => '[Error:]File Size Exceeded The PreSet Limit ',
        'No_Upload'     => '[Error]: Error Uploading File ',
    ];

    //Method __Construct
    /*************************************************************
        * Create default directory outside of public
        * Show dir path
        * @return string
    *************************************************************/
    public function __construct()
    {
        if (is_dir(Config::Data_Dir)) {
            $data = Config::Data_Dir;
        } else {
            self::mkDirs(Config::Data_Dir);
        }
        static::$fullDirPath = @$data;
    }

    // end method __construct

    public function systemDirs()
    {
        if (!is_dir('../Storage')) {
            self::mkDir('../Storage');
        }
        if (!is_dir('../Storage/Data')) {
            self::mkDir('../Storage/Data');
        }
        if (!is_dir('../Storage/Logs')) {
            self::mkDir('../Storage/Logs');
        }
        if (!is_dir('../Storage/Session')) {
            self::mkDir('../Storage/Session');
        }
        if (!is_dir('../Storage/Backup')) {
            self::mkDir('../Storage/Backup');
        }
    }

    //Method MkDir
    /*************************************************************
        * Create directory outside of public
        *
        * @param $name (string) string $name name of directory
        * @return boolean
    *************************************************************/
    public static function mkDir($name)
    {
        //if file doesnt exist
        if (!file_exists($name)) {
            //create it //also verify that it was created
            if (mkdir($name.'/', 0755, true)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //end method
    //Method MkDirs
    /*************************************************************
        * Create directory outside of public
        *
        * @param $name (string) string $name name of directory
        * @return boolean
    *************************************************************/
    public static function mkDirs($name)
    {
        //if file doesnt exist
        if (!file_exists(static::$fullDirPath.$name)) {
            //create it //also verify that it was created
            if (mkdir(static::$fullDirPath.$name.'/', 0755, true)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //end method

    //Method GenerateSalts
    /*************************************************************
        * generate salts for files
        *
        * @param string $length length of salts
        * @return string
    *************************************************************/
    public static function generateSalts($length)
    {
        return \Zest\Site\Site::salts($length);
    }

    //end method

    //Method Permission
    /*************************************************************
        * Change premission of file and folder
        * @param $params (array)
        * 		 'source' => file or folder
        *		 'premission' => premission set to be.
        * @return boolean
    *************************************************************/
    public static function permission($params)
    {
        if ($params) {
            if (!empty($params['source']) and !empty($params['Permission'])) {
                //verify chmod
                if (chmod(static::$fullDirPath.$params['source'], $params['Permission'])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //end method

    //Method CopyFilesAndFolder
    /*************************************************************
        * Copy files or folder
        * @param $params (array)
        * $params['status'] files or dir
        * $params['target'] => folder that file shoud copy
        * $params['files'] array of files one or multiple
        * $params['dirs'] array of dir one or muktiple
        * #issue folder not copying in windows
        * @return boolean
    *************************************************************/
    public function copyFilesAndFolder($params)
    {
        if (is_array($params)) {
            if ($params['status'] === 'files') {
                if (!is_dir(static::$fullDirPath.$params['target'].'/')) {
                    static::mkDirs($params['target'].'/');
                }
                foreach ($params['files'] as $file => $value) {
                    if (file_exists(static::$fullDirPath.$params['path'].'/'.$value)) {
                        copy(static::$fullDirPath.$params['path'].'/'.$value, static::$fullDirPath.$params['target'].'/'.$value);
                    }
                }
            }
            if ($params['status'] === 'dir') {
                if (!is_dir(static::$fullDirPath.$params['target'].'/')) {
                    static::$mkDirs($params['target'].'/');
                }
                foreach ($params['dirs'] as $file => $from) {
                    if (is_dir(static::$fullDirPath.$value.'/')) {
                        if (static::$ServerOS === 'WINNT' or static::$ServerOS === 'WIN32' or static::$ServerOS === 'Windows') {
                            shell_exec('xcopy '.static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } elseif (static::$ServerOS === 'Linux' or static::$ServerOS === 'FreeBSD' or static::$ServerOS === 'OpenBSD') {
                            shell_exec('cp -r '.$static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } elseif (static::$ServerOS === 'Unix') {
                            shell_exec('cp -r '.static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } else {
                            return static::$cecodes['No_Support_OS'].'<b>COPY</b>';
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    //end method

    //Method DelFilesAndFolders
    /*************************************************************
        * Delete the files or folder
        * @param $params (array)
        * $params['path'] string path
        * $params['status'] => files and dir accpeted
        * $params['files'] array of files one or multiple
        * $params['dir'] array of dir one or muktiple
        *
        * @return boolean
    *************************************************************/
    public function delFilesAndFolders($params)
    {
        if (is_array($params)) {
            if ($params['status'] === 'files') {
                foreach ($params['files'] as $file=>$value) {
                    if (file_exists(static::$fullDirPath.$params['path'].$value)) {
                        unlink(static::$fullDirPath.$params['path'].$value);
                    } else {
                        return false;
                    }
                }

                return true;
            }
            if ($params['status'] === 'dir') {
                foreach ($params['dir'] as $file=>$value) {
                    if (is_dir(static::$fullDirPath.$params['path'].$value)) {
                        rmdir(static::$fullDirPath.$params['path'].$value);
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }

    //end method

    //Method MovesFilesAndFolders
    /*************************************************************
        * Move files from one directory to another
        *
        * @param $params (array)
        * status required accpted files and dir
        * in files case files => array('one.txt','two.txt','three.txt');
        * to & from=> array is required provide full path in these to and from if select file form e.g F:\AndroidStudioProjects\AwesomeDictionary\.gradle\3.3\ you need add this in path then to add whatever want you move
        * @return boolean
    *************************************************************/
    public function movesFilesAndFolders($params)
    {
        if (is_array($params)) {
            if (isset($params['status']) and !empty($params['status'])) {
                if ($params['status'] === 'files') {
                    if (!is_dir($params['to'])) {
                        if (!file_exists($params['to'])) {
                            static::mkDirs($params['to']);
                        }
                    }
                    foreach ($params['files'] as $file) {
                        rename($params['from'].'/'.$file, $params['to'].'/'.$file);
                    }

                    return true;
                } elseif ($params['status'] === 'dir') {
                    if (!is_dir($params['to'])) {
                        if (!file_exists($params['to'])) {
                            static::mkDirs($params['to']);
                        }
                    } //end if
                    foreach ($params['from'] as $key => $from) {
                        if (static::$ServerOS === 'WINNT' or static::$ServerOS === 'Windows') {
                            shell_exec('move '.static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } elseif (static::$ServerOS === 'Linux' or static::$ServerOS === 'FreeBSD' or static::$ServerOS === 'OpenBSD') {
                            shell_exec('mv '.static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } elseif (static::$ServerOS === 'Unix') {
                            shell_exec('mv '.static::$fullDirPath.$from.' '.static::$fullDirPath.$params['to'].'/');
                        } else {
                            return static::$cecodes['No_Support_OS'].'<b>MOVE</b>';
                        }
                    } // end foreach
                }
            }
        } else {
            return false;
        }
    }

    //end method

    //Method FileUpload
    /*************************************************************
        * Upload file
        * @param $params (array)
        * $params string $params['file'] required file
        * $params string $params['target'] target dir sub dir of data folder
        * $params string $params['filetype'] type e.g image,media etc
        * errors possibles
        * 2220 => extension not matched
        * 222 => type not matched
        *
        * @return integer on fail fileName on success
    *************************************************************/
    public function fileUpload($params)
    {
        if (is_array($params)) {
            $exactName = basename($params['file']['name']);
            $fileTmp = $params['file']['tmp_name'];
            $fileSize = $params['file']['size'];
            $error = $params['file']['error'];
            $type = $params['file']['type'];
            $ext = pathinfo($params['file']['name'], PATHINFO_EXTENSION);
            $newName = static::generateSalts(30);
            $fileNewName = $newName.'.'.$ext;
            switch ($params['filetype']) {
                case 'image':
                    $allowerd_ext = ['jpg', 'png', 'jpeg', 'gif', 'ico', 'svg'];
                    break;
                case 'zip':
                    $allowerd_ext = ['zip', 'tar', '7zip', 'rar'];
                    break;
                case 'docs':
                    $allowerd_ext = ['pdf', 'docs', 'docx'];
                    break;
                case 'media':
                    $allowerd_ext = ['mp4', 'mp3', 'wav', '3gp'];
                    break;
                default:
                    // occur wrong skill of developers
                    //throw new \Exception(static::$cecodes['No_Support']." <b>{$ext}</b>",500);
                return static::$cecodes['No_Support']." <b>{$ext}</b>";
            } //end switch
            $AccpetedTypes = [
                                    'application/x-zip-compressed',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'image/gif',
                                    'image/jpeg',
                                    'image/jpeg',
                                    'audio/mpeg',
                                    'video/mp4',
                                    'application/pdf',
                                    'image/png',
                                    'application/zip',
                                    'application/et-stream',
                                    'image/x-icon',
                                    'image/icon',
                                    'image/svg+xml',
                    ];
            if (in_array($type, $AccpetedTypes) === false) {
                //throw new \Exception(static::$cecodes['No_Support']." <b>{$type}</b>",500);
                return static::$cecodes['No_Support']." <b>{$type}</b>";
            }
            if (in_array($ext, $allowerd_ext) === true) {
                if ($error === 0) {
                    if ($fileSize <= static::$fupmaxs) {
                        if (!is_dir(static::$fullDirPath.$params['target']) or !file_exists(static::$fullDirPath.$params['target'])) {
                            static::mkDirs($params['target'].'/');
                        }
                        $fileRoot = static::$fullDirPath.$params['target'].'/'.$fileNewName;
                        if (move_uploaded_file($fileTmp, $fileRoot)) {
                            return $fileNewName;
                        } else {
                            return static::$cecodes['No_Upload']."{$fileRoot}";
                        }
                    } else {
                        return static::$cecodes['Size_Limit'];
                    }
                } else {
                    return $error;
                }
            } else {
                return static::$cecodes['No_Support']." <b>{$ext}</b>";
                //throw new \Exception(static::$cecodes['No_Support']." <b>{$ext}</b>",500);
            }
        } else {
            return false;
        }
    }

    //end method

    //Method MultipleFileUpload
    /*************************************************************
        * Uploads multiple files file
        * @param $params (array)
        * $params string $params['file'] required file
        * $params string $params['target'] target dir sub dir of data folder
        * $params int $params['count'] using count function for count files
        * $params string $params['filetype'] type e.g image,media etc
        * errors possibles
        *
        * @return Array
    *************************************************************/
    public function multipleFileUpload($params)
    {//Storing status
        $status = [];
        if (is_array($params)) {
            //counting number of files
            $counter = $params['count'];
            //using loop for upload all files
            for ($i = 0; $i < $counter; $i++) {
                $exactName = basename($params['file']['name'][$i]);
                $fileTmp = $params['file']['tmp_name'][$i];
                $fileSize = $params['file']['size'][$i];
                $error = $params['file']['error'][$i];
                $type = $params['file']['type'][$i];
                $ext = pathinfo($params['file']['name'][$i], PATHINFO_EXTENSION);

                $newName = static::generateSalts(30);
                $fileNewName = $newName.'.'.$ext;
                switch ($params['filetype']) {
                    case 'image':				$allowerd_ext = ['jpg', 'png', 'jpeg', 'gif', 'ico', 'svg'];
                        break;
                    case 'zip':
                        $allowerd_ext = ['zip', 'tar', '7zip', 'rar'];
                        break;
                        case 'docs':
                        $allowerd_ext = ['pdf', 'docs', 'docx'];
                        break;
                    case 'media':
                        $allowerd_ext = ['mp4', 'mp3', 'wav', '3gp'];
                        break;
                        default:
                        // occur wrong skill of developers
                        $error['error'][$i] = static::$cecodes['No_Support']." <b>{$ext}</b>";
                } //end switch
                $AccpetedTypes = [
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'image/gif',
                                        'image/jpeg',
                                        'image/jpeg',
                                        'audio/mpeg',
                                        'video/mp4',
                                        'application/pdf',
                                        'image/png',
                                        'application/zip',
                                        'application/octet-stream',
                                        'image/x-icon',
                                    'image/icon',
                                    'image/svg+xml',
                        ];
                if (in_array($type, $AccpetedTypes) === false) {
                    $status['error'] = static::$cecodes['No_Support']." <b>{$type}</b>";
                }
                if (in_array($ext, $allowerd_ext) === true) {
                    if ($error === 0) {
                        if ($fileSize <= static::$fupmaxs) {
                            if (!is_dir(static::$fullDirPath.$params['target']) or !file_exists(static::$fullDirPath.$params['target'])) {
                                static::mkDirs($params['target'].'/');
                            }
                            $fileRoot = static::$fullDirPath.$params['target'].'/'.$fileNewName;
                            if (move_uploaded_file($fileTmp, $fileRoot)) {
                                $status['success'][$i] = $fileNewName;
                            } else {
                                $status['error'][$i] = static::$cecodes['No_Upload']."{$fileRoot}";
                            }
                        } else {
                            $status['error'][$i] = static::$cecodes['Size_Limit'];
                        }
                    } else {
                        $status['error'][$i] = $error;
                    }
                } else {
                    $status['error'][$i] = static::$cecodes['No_Support']." <b>{$ext}</b>";
                }
            }
            if (isset($status['error'])) {
                return $status['error'];
            } elseif (isset($status['success'])) {
                return $status['success'];
            } else {
                return falae;
            }
        } else {
            return false;
        }
    }

    //end method

    //Method FilesHandeling
    /*************************************************************
        * Handeling files
        *
        * @params string $params['mods'] Support six different mods
        *	'readonly' =>
        *	'read+write' =>
        *	'writeonly' =>
        *	'writeonlyoverride' =>
        *	'writeonlynotoverride' =>
        *	'write+readnotoverride' =>
        * @params string $params['target'] target dir sub dir of data folder
        * @params string $params['name'] Name of file
        * @params string $params['extension'] Extension of file
        * @params text $params['text'] text or data that write in file
        * @return integar on fail fileName on success
    *************************************************************/
    public function filesHandeling($params)
    {
        if (is_array($params)) {
            switch ($params['mods']) {
                case 'readonly':
                    $mod = 'r';
                    break;
                case 'read+write':
                    $mod = 'r+';
                    break;
                case 'writeonly':
                    $mod = 'w';
                    break;
                case 'writeonlyoverride':
                    $mod = 'w+';
                    break;
                case 'writeonlynotoverride':
                    $mod = 'a';
                    break;
                     case 'write+readnotoverride':
                    $mod = 'a+';
                    break;
                default:
                    return false;
            } //end switch
            $fopen = fopen(static::$fullDirPath.$params['target'].'/'.$params['name'].'.'.$params['extension'], $mod);
            fwrite($fopen, $params['text']);
            switch ($mod) {
                case 'r':
                case 'r+':
                case 'a+':
                    return fread($fopen, filesize(static::$fullDirPath.$params['target'].'/'.$params['name'].'.'.$params['extension']));
                    break;
                case 'w':
                case 'w+':
                case 'a':
                    return true;
                    break;
                default:
                return false;
            } //end switch
        } else {
            return false;
        }
    }

    //end method
} //end class
