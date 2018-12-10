#! /bin/bash

zest ()
{
	TEXT_BOLD=$(tput bold)
	echo -e "\e[32m ${TEXT_BOLD} ZEST FRAMEWORK 3.0.0\e[32m"
	MESSAGE_ERROR="\033[Available options ${TEXT_BOLD}s|S=> start php , v|v => PHP Version and z-v|Z-V => ZEST FRAMEWORK version]\033"
	if  [[ $CMD == "s" || $CMD == 'S' ]]; then
		PHP=$(which php)
		PHP_VERSION_INFO=$(php -S localhost:8080)
		echo $PHP_VERSION_INFO 
	 elif [[ $CMD == "v" || $CMD == "V" ]]; then
		PHP=$(which php)
		PHP_VERSION_INFO=$($PHP -v)
		echo $PHP_VERSION_INFO
	 elif [[ $CMD == "z-v" || $CMD == "Z-V" ]]; then
	 		echo -e "${TEXT_BOLD}3.0.0"	
	 else
	   echo -e $MESSAGE_ERROR		
	fi	
}