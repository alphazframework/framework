## Zest Framework - V3.0.0 {Dev} 
1. Update site class (fix issue in redirect method prev parameter not working)
2. Add view function in functions.php
3. Added getInput method in Router class
4. Allow to get input using $this->input properity in controller
5. Update userInfo class fix issue in firefox browser return null in browserName and version
6. Added Formats class (for converting time and data unit in houam readable form)
7. Added Identicon library.
8. Added FTP class.
9. Added ipv6,alpha and subnet validation rule method.
10. Added FileHandling class.
11. Added Avatar package.
12. Fix issue router cached either router cache is set to off.
13. Added Model class for easily access to models.
14. Added model function
   - Now you can access any model like <?php model('name')->method() //or model('folder\model')->method()?>	
15. Update auth class added delete method/member function for delete the user special thanks (https://zestframework.xyz/community/view/uh5UOqe).
16. Added save method in Avatar and Identicon class.
17. Update Formats class Added formatSeconds for converting time to h:m:s.
18. Update Signup,Signin class fix issue send verification email either not set to true.
19. Update Component Router class code optimization.
20. Update Component Controller class code optimization (reuse of controller class). 	
21. Update Validation Handler class allow users to translate the defaults msgs of validations.
22. Added pagination class and pagination function.
23. Fix typo in language string class Local to Locale.
24. Update files class, implement folder creation recursively (special thanks => https://github.com/NivaldoMS).
25. Added shell script file for starting php server , php version and Zest framework version.
26. Update Language Class.
27. Update Root class fix typos.
28. Added HTTP Request library more will added soon.
29. Add HTTP Redirect class.
30. Add HTTP Response class.
31. Update HTTP Response class.
32. Added HTTP Message class.
33. Added HTTP Headers classs.
34. Added HTTP URI class.
35. Update Files Class.
    	- Add touch method for (Sets access and modification time of file).
	- Add chown method for (Change the owner of files).
36. Added HTTP Client Classes.
37. Added Middleware supports in Routes.
38. Added few more rests routes OPTIONS, TRACE and CONNECT.
39. Update Logger class add setCustumFile() method.
40. Update Dependency Injection system.
    - now you can use container() and __container() function to access IOC class.
41. Added Configuraion class.
42. Added close() method in FileHandling class.
42. Added New cache System old system is removed.
	- Supported Adapters
	  A. APC
	  B. APCU
	  C. FileSystem
	  D. Memcache
	  E. Memcached
	  F. Redis
	  G. Session
43. Added Hashing System.
44. Added Encryption Class.
	- Support Sodium and OpenSsl encryption.
45. Added LanguageCodes Trait.
46. Added Whoops custum library for show more friendly error log on display if turn on.
47. Added Class aliases support.
48. Added `all` method in Router class for supporting all requested method.
49. Added TimeZone class.
50. Add option to change timeZone of your application.
51. Added PHPUnit testing.
52. Added Constructur args support in container class.
53. Update Session & Cookie class allow developer to set/delete/get Multiple values.
54. Added Component Manipulator class.
55. Added Sitemap package.
56. Avoid session hijacking attack.
57. Added Arrays Package.