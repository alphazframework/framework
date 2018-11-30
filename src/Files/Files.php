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

class Files
{
    /*
     * Mine types of file
    */
    private $mineTypes = [
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
    /*
     * Types
    */
    private $types = [
        'image' => ['jpg', 'png', 'jpeg', 'gif', 'ico', 'svg'],
        'zip'   => ['zip', 'tar', '7zip', 'rar'],
        'docs'  => ['pdf', 'docs', 'docx'],
        'media' => ['mp4', 'mp3', 'wav', '3gp'],
    ];

    /**
     * Create zest system dir.
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
    }

    /**
     * Add the mine type.
     *
     * @param $type correct mine type.
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
     * @param $type correct type.
     *        $sub extensions
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
     * @param $name name of dir with path.
     *
     * @return bool
     */
    public function mkDir($name)
    {
        if (!is_dir($name)) {
            return (mkdir($name)) ? true : false;
        }

        return false;
    }

    /**
     * Make the dir.
     *
     * @param $source name of file or directory with path.
     *        $pre valid premission
     *
     * @return bool
     */
    public function permission($source, $pre)
    {
        if (!is_dir($name)) {
            return (file_exists($source)) ? chmod($source, $pre) : false;
        }

        return false;
    }

    /**
     * Copy files.
     *
     * @param $source name of file or directory with path.
     *        $target target directory
     *        $files (array) files to be copy
     *
     * @return void
     */
    public function copyFiles($source, $target, $files)
    {
        $this->mkDir($target);
        foreach ($files as $file => $value) {
            if (file_exists($source.$value)) {
                copy($source.$value, $target.$value);
            }
        }
    }

    /**
     * Move files.
     *
     * @param $source name of file or directory with path.
     *        $target target directory
     *        $files (array) files to be move
     *
     * @return void
     */
    public function moveFiles($source, $target, $files)
    {
        $this->mkDir($target);
        foreach ($files as $file => $value) {
            if (file_exists($source.$value)) {
                rename($source.$value, $target.$value);
            }
        }
    }

    /**
     * Delete files.
     *
     * @param $file name of file with path.
     *
     * @return void
     */
    public function deleteFiles($files)
    {
        foreach ($files as $file => $value) {
            if (file_exists($value)) {
                unlink($value);
            }
        }
    }

    /**
     * Copy dirs.
     *
     * @param $source directory with path.
     *        $target target directory
     *        $files (array) dirs to be copy
     *
     * @return void
     */
    public function copyDirs($source, $target, $dirs)
    {
        $this->mkDir($target);
        $serverOs = (new \Zest\Common\OperatingSystem())->get();
        $command = ($serverOs === 'Windows') ? 'xcopy ' : 'cp -r ';
        foreach ($dirs as $dir => $value) {
            if (is_dir($source.$value)) {
                shell_exec($command.$source.$value.' '.$target.$value);
            }
        }
    }

    /**
     * Move dirs.
     *
     * @param $source directory with path.
     *        $target target directory
     *        $dir (array) dir to be move
     *
     * @return void
     */
    public function moveDirs($source, $target, $dirs)
    {
        $this->mkDir($target);
        $command = ($serverOs === 'Windows') ? 'move ' : 'mv ';
        foreach ($dirs as $dir => $value) {
            if (is_dir($source.$value)) {
                shell_exec($command.$source.$value.' '.$target.$value);
            }
        }
    }

    /**
     * Delete dirs.
     *
     * @param $dir Directory with path.
     *
     * @return void
     */
    public function deleteDirs($dir)
    {
        foreach ($files as $file => $value) {
            if (is_dir($value)) {
                rmdir($value);
            }
        }
    }

    /**
     * Upload file.
     *
     * @param $file file to be uploaded.
     *        $target target where file should be upload
     *        $imgType supported => image,media,docs,zip
     *        $maxSize file size to be allowed
     *
     * @return void
     */
    public function fileUpload($file, $target, $imgType, $maxSize = 7992000000)
    {
        $exactName = basename($file['name']);
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $error = $file['error'];
        $type = $file['type'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = \Zest\Site\Site::salts(30);
        $fileNewName = $newName.'.'.$ext;
        $allowerd_ext = $this->types[$imgType];
        if (in_array($type, $this->mineTypes) === false) {
            return [
                'status' => 'error',
                'code'   => 'mineType',
            ];
        }
        if (in_array($ext, $allowerd_ext) === true) {
            if ($error === 0) {
                if ($fileSize <= $maxSize) {
                    $this->mkdir($target);
                    $fileRoot = $target.$fileNewName;
                    if (move_uploaded_file($fileTmp, $fileRoot)) {
                        return [
                            'status' => 'success',
                            'code'   => $fileNewName,
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'code'   => 'somethingwrong',
                        ];
                    }
                } else {
                    return [
                        'status' => 'error',
                        'code'   => 'exceedlimit',
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'code'   => $error,
                ];
            }
        } else {
            return [
                    'status' => 'error',
                    'code'   => 'extension',
            ];
        }
    }

    /**
     * Upload files.
     *
     * @param $files (array) files to be uploaded.
     *        $target target where file should be upload
     *        $imgType supported => image,media,docs,zip
     *        $maxSize file size to be allowed
     *
     * @return void
     */
    public function filesUpload($files, $target, $imgType, $count, $maxSize = 7992000000)
    {
        $status = [];
        for ($i = 0; $i < $count; $i++) {
            $exactName = basename($files['name'][$i]);
            $fileTmp = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $error = $files['error'][$i];
            $type = $files['type'][$i];
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newName = \Zest\Site\Site::salts(30);
            $fileNewName = $newName.'.'.$ext;
            $allowerd_ext = $this->types[$imgType];
            if (in_array($type, $this->mineTypes) === false) {
                $status[$i] = [
                    'status' => 'error',
                    'code'   => 'mineType',
                ];
            }
            if (in_array($ext, $allowerd_ext) === true) {
                if ($error === 0) {
                    if ($fileSize <= $maxSize) {
                        $this->mkdir($target);
                        $fileRoot = $target.$fileNewName;
                        if (move_uploaded_file($fileTmp, $fileRoot)) {
                            $status[$i] = [
                                'status' => 'success',
                                'code'   => $fileNewName,
                            ];
                        } else {
                            $status[$i] = [
                                'status' => 'error',
                                'code'   => 'somethingwrong',
                            ];
                        }
                    } else {
                        $status[$i] = [
                            'status' => 'error',
                            'code'   => 'exceedlimit',
                        ];
                    }
                } else {
                    $status[$i] = [
                        'status' => 'error',
                        'code'   => $error,
                    ];
                }
            } else {
                $status[$i] = [
                        'status' => $error,
                        'code'   => 'extension',
                ];
            }
        }

        return $status;
    }
}
