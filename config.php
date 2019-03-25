<?php

/* Zest Frameowrk config file */
return [

    /*
     * Basic configuration.
     */
   'Config' => [
    /*
        //App Name
    */
        'app_name'                => 'Zest Framework',
    /*
        //App Version
    */
        'app_version'             => '3.0.0',
    /*
        //Display Error (recommended turn off in production)
    */
        'SHOW_ERRORS'             => true,
    /*
        //Default language
    */
        'language'                => 'en',
    /*
        //Default data dr
    */
        'data_dir'                => 'Data/',
    /*
        //Default cache dr
    */
        'cache_dir'               => 'Cache/',
    /*
        //Default session path
    */
        'session_path'            => 'Session/',
    /*
        //Current theme
    */
        'theme_path'              => 'App/Views/',
    /*
        //Router cache
    */
        'router_cache'            => false,
    /*
        //When router cache should regenerate
    */
        'router_cache_regenerate' => 3600,
    /*
        //Maintance mode
    */
        'maintenance'             => false,
    /*
        //Default time zone
    */
        'time_zone'               => 'UTC',
    ],

    /* Encryption */
    'encryption' => [
        /*
        | Supported "openssl" and "sodium"
        */
        'driver' => 'openssl',

        // Key, that is use to encrypt and decrypt.
        'key' => 'euyq74tjfdskjFDSGq74taeoqiertp',
    ],

     /* Hashing */
    'hashing' => [
        /* Default Hash Driver
        | Supported: "bcrypt", "argon2i", "argon2id"
        */
        'driver' => 'argon2id',

        /*
        | Bcrypt Options

        | Here you may specify the configuration options that should be used when
        | passwords are hashed using the Bcrypt algorithm. This will allow you
        | to control the amount of time it takes to hash the given password.
        |
        */
        'bcrypt' => [
            'cost' => 10,
        ],

        /*
        | Argon Options

        | Here you may specify the configuration options that should be used when
        | passwords are hashed using the Bcrypt algorithm. This will allow you
        | to control the amount of time it takes to hash the given password.
        |
        */
        'argon' => [
            'memory'  => 1024,
            'threads' => 2,
            'time'    => 2,
        ],
    ],

    /* Cache Configuration */

    /*    |--------------------------------------------------------------------------
    | Cache    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    | Supported: "apc", "apcu" , "session", "file", "memcached", "memcached", "redis"
    |
    */
    'cache' => [
        'driver' => 'file',

        'memcache' => [
            'host' => 'memcache-host',
            'port' => 'memcache-port',
        ],
        'memcached' => [
            'host'   => 'memcached-host',
            'port'   => 'memcached-port',
            'weight' => 'memcached-weight',
        ],
        'redis' => [
            'host' => 'redis-host',
            'port' => 'redis-port',
        ],
    ],

    /*
     * Database configuration.
     */
    'Database' => [
        /* Database DRIVE */
        'DB_DRIVER' => 'database-drive', // mysql is recommendeds
        /* Database NAME */
        'DB_NAME' => 'database-name',
        /* MYSQL HOST */
        'MYSQL_HOST' => 'mysql-host',
        /* MYSQL PASS */
        'MYSQL_USER' => 'mysql-user',
        /* MYSQL PASS*/
        'MYSQL_PASS' => 'mysql-pass',
        /* SQLite name with path */
        'SQLITE_NAME' => 'path/to/sqlite',
    ],

    /*
     * Auth configuration.
     */
    'Auth' => [
        /* Auth database name */
        'DB_NAME' => 'db-name',
        /* Auth database table name*/
        'DB_TABLE' => 'db-table',
        /* Auth default verification link */
        'VERIFICATION_LINK' => '/account/verify/',
        /* Auth default password reset link */
        'RESET_PASSWORD_LINK' => '/account/reset/password',
        /* Is send auth relate email over smtp. */
        'IS_SMTP' => false,
        /* Is user need to verify their email */
        'IS_VERIFY_EMAIL' => false,
        /* Is user password should be strong? */
        'STICKY_PASSWORD' => false,
    ],

    /*
     * Email configuration.
     */
    'email' => [
        /* Site Email */
        'SITE_EMAIL' => 'site-email', // mysql is recommendeds
        /* SMTP HOST */
        'SMTP_HOST' => 'smtp-host',
        /* SMTP USER */
        'SMTP_USER' => 'smtp-user',
        /* SMTP PASS */
        'SMTP_PASS' => 'smtp-pass',
        /* SMTP PORT*/
        'SMTP_PORT' => 'smtp-port',
    ],

    /* Dependencies */
    /* class that should be automatically resolved by the IOC */
    'dependencies' => [
        //examples
        'version' => \Zest\Common\Version::class,
        'pass'    => \Zest\Common\passwordManipulation::class,
    ],

    /*
     * Files Configuration
    */
    'files' => [
        //Default file mine type
        'mine' => [
            'type' => [
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
            ],
        ],

        //Default types
        'types' => [
            'image' => ['jpg', 'png', 'jpeg', 'gif', 'ico', 'svg'],
            'zip'   => ['zip', 'tar', '7zip', 'rar'],
            'docs'  => ['pdf', 'docs', 'docx'],
            'media' => ['mp4', 'mp3', 'wav', '3gp'],
        ],
    ],

    /*
     *
     * Class aliases
     *
     *
     * The key is the alias and the value is the actual class.
     */
    'class_aliases' => [

    ],

];
