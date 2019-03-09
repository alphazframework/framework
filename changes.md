## Zest Framework - V3.0.0 {Dev} 
1. Update site class (fix issue in redirect method prev parameter not working)
2. Update site class (fix double slashes after base url)
3. Add sqlite drive
4. Update Query class => {
     a => Fix prepareWhere method
     b => Support DISTINCT in select query
}
5. Add view function in functions.php
6. Added getInput method in Router class
7. Allow to get input using $this->input properity in controller
8. Adding comments in Router & Controller class
9. Update getInput method form Router class (Add missing argument)
10. Update userInfo class fix issue in firefox browser return null in browserName and version
11- Update UserInfo Class
12. Added Formats class (for converting time and data unit in houam readable form)
13. Update the Formats class adding comment to friendlyTime method
14. Update Formats class fix logical mistake.
15. Added Identicon library.
16. Added FTP class.
17. Added comments to Validation system.
18. Added ipv6,alpha and subnet validation rule method.
19. Fix bug in StickyRule validation class.
20. Added FileHandling class.
21. Update Logger class by using new FileHandling class.
22. Update ROOT class fix logs route.
23. Added Avatar package.
24. Fix issue router cached either router cache is set to off.
25. Update router Cache system.
26. Added Model class for easily access to models.
27. Added model function
   - Now you can access any model like <?php model('name')->method() //or model('folder\model')->method()?>	
28. Update auth class added delete method/member function for delete the user special thanks (https://zestframework.xyz/community/view/uh5UOqe).
29. Added save method in Avatar and Identicon class.
30. Update Files class
    - Code optimization.
    - Update methods 
    - Delete useless code.
31. Move FileHandling class to Files/
32. Update Formats class Added formatSeconds for converting time to h:m:s.
33. Update User class fix typo mistake.
34. Update Signup,Signin class fix issue send verification email either not set to true.
35. Update Component Router class code optimization.
36. Update Component Controller class code optimization (reuse of controller class). 	
37. Update Validation Handler class allow users to translate the defaults msgs of validations.
38. Update FileHandling class fix logical mistake.
39. Added two functions in helper.php (read and write file).
40. Added pagination class and pagination function.
41. Update Pagination class fix logical mistake.
42. Fix typo in language string class Local to Locale.
43. Fix typo mistake in Files class.
44. Update FTP class fix typo.
45. Update Conversion class Code Optimization delete unnecessary code.
46. Update files class, implement folder creation recursively (special thanks => https://github.com/NivaldoMS).
47. Added shell script file for starting php server , php version and Zest framework version.
48. Added callback in Router for creating protected page according to specific certia
   - know issue: its will not work if cache is enable.
49. Fix sessionUnset() method to delete all sessions.
50. Update systemMessage class fix serveral issues.
51. Update Session class fix session not deleting issue.
52. Update Pagination Ssystem 
    - Allow developers to add custum class to ul,li and a tag.
53. Update Language Class.
54. Update Root class fix typos.
55. Delete Language Class form Component 
	- Now you can use printl function in component as well
56. Update PasswordManipulation class
    - Added method for set custum password length
57. Added HTTP Request library more will added soon.
58. Update Router class using http\Request.
59. Add HTTP Redirect class.
60. Add HTTP Response class.
61. Update HTTP Response class.
62. Added HTTP Message class.
63. Added HTTP Headers classs.
64. Added HTTP URI class.
65. Update Files Class.
    	- Add touch method for (Sets access and modification time of file).
	- Add chown method for (Change the owner of files).
63. Added HTTP Client Classes.
67. Complete HTTP Package.
68. Remove Useless CSRF class.
69. Remove function is_ajax() form helpers.php.
70. Update Input class remove csrf methods.
71. Added Middleware supports in Routes.
73. Added few more rests routes OPTIONS, TRACE and CONNECT.
73. Added Middleware supports in Components.
74. Update Logger class add setCustumFile() method.
75. Update Expection class use Logger in expection for creating log file.
76. Update input Class (code optimization)
77. Update Dependency Injection system.
    - now you can use container() and __container() function to access IOC class.
78. Added Configuraion class.
79. Update Zest Classes using new config file.
80. Added destroy method in session class for destroy all sessions.
81. Added close() method in FileHandling class.
82. Added New cache System old system is deprecated.
	- Supported Adapters
	  A. APC
	  B. APCU
	  C. FileSystem
	  D. Memcache
	  E. Memcached
	  F. Redis
	  G. Session
83 Update router cache and router middleware.	  
84. Remove (48) Callbacks form router.
85. Added Hashing System.
86. Deprecated passwordManipulation class hashMatched and hashPassword method.
87. Added Encryption Class.
	- Support Sodium and OpenSsl encryption.
88. Added LanguageCodes Trait.
89. Added Whoops custum library for show more friendly error log on display if turn on.
90. Added Class aliases support.
91. Added All method in Router class for supporting all requested method.
92. Added TimeZone class.
93. Add option to change timeZone of your application.
94. Added PHPUnit testing.
95. Added Constructur args support in container class.
96. Update Session & Cookie class allow developer to set/delete/get Multiple values.
97. Added Component Manipulator class.
