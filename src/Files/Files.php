<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Files;

use Zest\Data\Conversion;

class Files
{
    /**
     * Mine Types of files.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $mineTypes = [];

    /**
     * Types.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $types = [];

    /**
     * The default value for recursive create dirs.
     *
     * @since 3.0.0
     *
     * @var bool
     */
    private $recursiveDirectories = true;

    /**
     * Default chmod.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $defCHMOD = 0755;

    /**
     * __construct.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $files = Conversion::objectArray(__config('files'));
        $this->mineTypes = $files['mine']['type'];
        $this->types = $files['types'];
    }

    /**
     * Create zest system dir.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function systemDirs()
    {
        $this->mkDir('../Storage');
        $this->mkDir('../Storage/Data');
        $this->mkDir('../Storage/Logs');
        $this->mkDir('../Storage/Session');
        $this->mkDir('../Storage/Backup');
        $this->mkDIr('../Storage/Cache');
    }

    /**
     * Change the default chmod.
     *
     * @param mixed $chomd Valid chmod
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function changeDefaultChmod($chmod)
    {
        return ($chmod === null) ? $this->defCHMOD : $this->defCHMOD = $chmod;
    }

    /**
     * Create recurisve dir.
     *
     * @param mixed $value recursive status true|false.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function recursiveCreateDir($value = null)
    {
        return ($value === null) ? $this->recursiveDirectories : $this->recursiveDirectories = $value;
    }

    /**
     * Add the mine type.
     *
     * @param (string) $type Correct mine type.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addMineTypes($type)
    {
        array_push($this->mineTypes, $type);
    }

    /**
     * Add the extemsio.
     *
     * @param (string) $type Correct type.
     * @param (string) $sub  Extensions/
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addExt($type, $ext)
    {
        array_push($this->types[$type], $ext);
    }

    /**
     * Make the dir.
     *
     * @param (string) $name      Name of dir with path.
     * @param (string) $recursive Recursive mode create: null|true|false.
     * @param (string) $chmod     Directory permission on create: default 0755.
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function mkDir($name, $recursive = null, $chmod = null)
    {
        // test the recursive mode with default value
        $recursive = ($recursive === null) ? $this->recursiveDirectories : $recursive;
        // test the chmod with default value
        $chmod = ($chmod === null) ? $this->defCHMOD : $chmod;
        if (!is_dir($name)) {
            return (mkdir($name)) ? true : false;
        }

        return false;
    }

    /**
     * Change the permission.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (mixed)  $pre    Valid permission.
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function permission($source, $pre)
    {
        if (!is_dir($source)) {
            return (file_exists($source)) ? chmod($source, $pre) : false;
        }

        return false;
    }

    /**
     * Change the owner of an array of files.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (array)  $files  Files to be copy.
     * @param (mixed)  $user   The new owner user name.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function chown($source, $files, $user)
    {
        foreach ($files as $file => $value) {
            if (file_exists($source.$value)) {
                if (@chown($file, $user) === false) {
                    throw new \RuntimeException("The ownership of {$file} can not change", 500);
                }
            }
        }
    }

    /**
     * Sets access and modification time of file.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (array)  $files  Files to be copy.
     * @param (int)    $time   The touch time as a Unix timestamp.
     * @param (int)    $atime  The access time as a Unix timestamp.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function touch($source, $files, $time = null, $atime = null)
    {
        foreach ($files as $file => $value) {
            if (file_exists($source.$value)) {
                $touch = $time ? @touch($file, $time, $atime) : @touch($file);
                if ($touch !== true) {
                    return false;
                }
            }
        }
    }

    /**
     * Copy file.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (string) $target Target directory.
     * @param (string) $files  Files to be copy.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function copyFile($source, $target, $file)
    {
        $this->mkDir($target);
        if (file_exists($source.$file)) {
            copy($source.$file, $target.$file);
        }
    }

    /**
     * Copy files.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (string) $target Target directory.
     * @param (array)  $files  Files to be copy.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function copyFiles($source, $target, $files)
    {
        foreach ($files as $file) {
            $this->copyFile($source, $target, $file);
        }
    }

    /**
     * Move file.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (string) $target Target directory.
     * @param (string) $file   Files to be moved.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function moveFile($source, $target, $file)
    {
        if (file_exists($source.$file)) {
            rename($source.$file, $target.$file);
        }
    }

    /**
     * Move files.
     *
     * @param (string) $source Name of file or directory with path.
     * @param (string) $target Target directory.
     * @param (array)  $files  Files to be moved.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function moveFiles($source, $target, $files)
    {
        foreach ($files as $file) {
            $this->moveFile($source, $target, $files);
        }
    }

    /**
     * Delete file.
     *
     * @param (string) $file Name of file with path.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Delete files.
     *
     * @param (array) $file Name of file with path.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteFiles($files)
    {
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
    }

    /**
     * Copy dir.
     *
     * @param (string) $source Directory with path.
     * @param (string) $target Target directory.
     * @param (string) $dir    Directory to be copied.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function copyDir($source, $target, $dir)
    {
        $this->mkDir($target);
        $serverOs = (new \Zest\Common\OperatingSystem())->get();
        $command = ($serverOs === 'Windows') ? 'xcopy ' : 'cp -r ';
        if (is_dir($source.$dir)) {
            shell_exec($command.$source.$dir.' '.$target);
        }
    }

    /**
     * Copy dirs.
     *
     * @param (string) $source Directory with path.
     * @param (string) $target Target directory.
     * @param (array)  $dirs   Directories to be copied.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function copyDirs($source, $target, $dirs)
    {
        foreach ($dirs as $dir) {
            $this->copyDir($source, $target, $dir);
        }
    }

    /**
     * Move dir.
     *
     * @param (string) $source Directory with path.
     * @param (string) $target Target directory.
     * @param (string) $dir    Directory to be copied.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function moveDir($source, $target, $dir)
    {
        $this->mkDir($target);
        $serverOs = (new \Zest\Common\OperatingSystem())->get();
        $command = ($serverOs === 'Windows') ? 'move ' : 'mv ';
        if (is_dir($source.$dir)) {
            shell_exec($command.$source.$dir.' '.$target);
        }
    }

    /**
     * Move dirs.
     *
     * @param (string) $source Directory with path.
     * @param (string) $target Target directory.
     * @param (array)  $dirs   Dirs to be copy.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function moveDirs($source, $target, $dirs)
    {
        foreach ($dirs as $dir) {
            $this->moveDir($source, $target, $dir);
        }
    }

    /**
     * Delete dir.
     *
     * @param (string) $dir Directory with path.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteDir($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDir($dir.DIRECTORY_SEPARATOR.$item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    /**
     * Delete dirs.
     *
     * @param (array) $dirs Directory with path.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteDirs($dirs)
    {
        foreach ($dirs as $dir) {
            $this->deleteDir($dir);
        }
    }

    /**
     * Upload file.
     *
     * @param (string) $file     File to be uploaded.
     * @param (string) $target   Target where file should be uploaded.
     * @param (string) $fileType Supported => image,media,docs,zip.
     * @param (int)    $maxSize  File size to be allowed.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function fileUpload($file, $target, $fileType, $maxSize = 7992000000)
    {
        $exactName = basename($file['name']);
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $error = $file['error'];
        $type = $file['type'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = \Zest\Site\Site::salts(30);
        $fileNewName = $newName.'.'.$ext;
        $allowerd_ext = $this->types[$fileType];
        if (in_array($type, $this->mineTypes) === false) {
            return [
                'status'  => 'error',
                'code'    => 'mineType',
                'message' => sprintf(printl('z:files:error:mine:type'), $type),
            ];
        }
        if (in_array($ext, $allowerd_ext) === true) {
            if ($error === 0) {
                if ($fileSize <= $maxSize) {
                    $this->mkdir($target);
                    $fileRoot = $target.$fileNewName;
                    if (is_uploaded_file($fileTmp)) {
                        if (move_uploaded_file($fileTmp, $fileRoot)) {
                            return [
                                'status'  => 'success',
                                'code'    => $fileNewName,
                                'message' => printl('z:files:success'),
                                'name'    => $exactName,
                            ];
                        } else {
                            return [
                                'status'  => 'error',
                                'code'    => 'somethingwrong',
                                'message' => printl('z:files:error:somethingwrong'),
                            ];
                        }
                    } else {
                        return [
                            'status'  => 'error',
                            'code'    => 'invilidfile',
                            'message' => printl('z:files:error:invilid:file'),
                        ];
                    }
                } else {
                    return [
                        'status'  => 'error',
                        'code'    => 'exceedlimit',
                        'message' => sprintf(printl('z:files:error:exceed:limit'), $maxSize),
                    ];
                }
            } else {
                return [
                    'status'  => 'error',
                    'code'    => $error,
                    'message' => $error,
                ];
            }
        } else {
            return [
                    'status'  => 'error',
                    'code'    => 'extension',
                    'message' => sprintf(printl('z:files:error:extension'), $ext),
            ];
        }
    }

    /**
     * Upload files.
     *
     * @param (array)  $files    Files to be uploaded.
     * @param (string) $target   Target where file should be upload.
     * @param (string) $fileType Supported => image,media,docs,zip.
     * @param (int)    $count    Number of file count.
     * @param (int)    $maxSize  File size to be allowed.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function filesUpload($files, $target, $fileType, $count, $maxSize = 7992000000)
    {
        $status = [];
        for ($i = 0; $i <= $count; $i++) {
            $exactName = basename($files['name'][$i]);
            $fileTmp = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $error = $files['error'][$i];
            $type = $files['type'][$i];
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newName = \Zest\Site\Site::salts(30);
            $fileNewName = $newName.'.'.$ext;
            $allowerd_ext = $this->types[$fileType];
            if (in_array($type, $this->mineTypes) === false) {
                $status[$i] = [
                    'status'  => 'error',
                    'code'    => 'mineType',
                    'message' => sprintf(printl('z:files:error:mine:type'), $type),
                ];
            }
            if (in_array($ext, $allowerd_ext) === true) {
                if ($error === 0) {
                    if ($fileSize <= $maxSize) {
                        $this->mkdir($target);
                        $fileRoot = $target.$fileNewName;
                        if (is_uploaded_file($fileTmp)) {
                            if (move_uploaded_file($fileTmp, $fileRoot)) {
                                $status[$i] = [
                                    'status'  => 'success',
                                    'code'    => $fileNewName,
                                    'message' => printl('z:files:success'),
                                    'name'    => $exactName,
                                ];
                            } else {
                                $status[$i] = [
                                    'status'  => 'error',
                                    'code'    => 'somethingwrong',
                                    'message' => printl('z:files:error:somethingwrong'),
                                ];
                            }
                        } else {
                            return [
                                'status'  => 'error',
                                'code'    => 'invilidfile',
                                'message' => printl('z:files:error:invilid:file'),
                            ];
                        }
                    } else {
                        $status[$i] = [
                            'status'  => 'error',
                            'code'    => 'exceedlimit',
                            'message' => sprintf(printl('z:files:error:exceed:limit'), $maxSize),
                        ];
                    }
                } else {
                    $status[$i] = [
                        'status'  => 'error',
                        'code'    => $error,
                        'message' => $error,
                    ];
                }
            } else {
                $status[$i] = [
                        'status'  => 'error',
                        'code'    => 'extension',
                        'message' => sprintf(printl('z:files:error:extension'), $ext),
                ];
            }
        }

        return $status;
    }
}
