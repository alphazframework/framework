## Zest Framework - V3.0.0 {Dev}

### New Features.
1. Added Identicon Library.
2. Added FTP Class.
3. Added FileHandling Classs.
4. Added Avatar Package.
5. Added Container Package.
6. Added Model Class (to access models  {Now you can access any model like <?php model('name')->method() //or model('folder\model')->method()?>	}).
7. Added Pagination Class and their respective functions.
8. Added HTTP Client Library/Package.
9. Added New Cache Library/Package.
	- Supported Adapters
	  A. APC
	  B. APCU
	  C. FileSystem
	  D. Memcache
	  E. Memcached
	  F. Redis
	  G. Session
10. Added Encryption Library/Package {Sodium,openSSL}.
11. Added Hashing Library/Package.
12. Added Whoops Library/Pacakge  (to show more friendly error log on display if turn on).
13. Added Component Manipulator Class.
14. Added Sitemap Library/Package.
15. Added Arrays Library/Package.
16. Added String Library/Package.
17. Added TimeZone Class.
18. Added LanguageCodes Trait.
19. Added ClassAlias Class.
20. Added FileInfo Class.

### Fixes
1. Update site class (fix issue in redirect method , prev parameter were not working).
2. Update userInfo class (fix issue FireFox browser return NULL).
3. Fix Router Cache issue (Cache seems to be on even it were off).
4. Update Signup,Signin class fix issue send verification email.
5. Fix typo in language string class Local to Locale.
6. Fix typos in Root Class.
7. Avoid session hijacking attack.

### Added Function or Method.
1. Added view function in `function.php`
2. Added getInput method in `Router` class
3. Allow to get input using $this->input properity in `controller`
4. Added ipv6,alpha and subnet `validation` rule method.
5. Added delete method in `user` class.
6. Added touch & chown method in `Files` class.
7. Added recursiveCreateDir method in `Files` class (Special thanks [Nivaldo MS
](https://github.com/NivaldoMS)).
8. Added setCustumFile method in `Logger` class.
9. Added close method in `FileHandling` class.
10. Added OPTIONS, TRACE, CONNECT, ALL rests methods in `Router` class.
11. Added setMultiple, deleteMultiple, getMultiple methods in `Session` class.
12. Added setMultiple, deleteMultiple, getMultiple methods in `Cookie` class.
13. Update `\Site::Salts` method add `$special` argument support to add, special chars in salts.

### Optimizations
1. Allow translations of default validations messages.
2. Optimizations of Components package.
3. Optimizations of PasswordManipulation Class.

### Unit Testing.
1. Added PHPUnit testing.
