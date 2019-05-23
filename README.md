Модуль для работы с CityAirAPI:
--------------------------

* для подключения и работы модуля необходимо подключить файл в рабочем окружении и указать данные своего аккаунта

    	require_once("CityAirAPI.php");
    	$CAApi = new CityAirAPI();
    	$CAApi->login ='YOUR_LOGIN';
    	$CAApi->password = 'YOUR_PASSWORD';

* информация с определенного устройства, где DEVICE_ID = id устройства

    	$CAApi->getDeviceById('DEVICE_ID');

* информация обо всех устройствах 
 
        $CAApi->getAllDevices();
    
* получение информации о пакетах с выбранной станции с фильтром по параметрам

    	$args = [
    	  "FilterType"      => '',
    	  "DeviceId"        => '',
    	  "MaxPacketsCount" => '',
    	  "Skip"            => '',
    	  "BeginTime"       => '',
    	  "EndTime"         => '',
    	  "LastPacketId"    => ''
    	];
    	$CAApi->getPackets($args);
    "BeginTime" и "EndTime" указываются в формате 
        
        2018-06-04T09:31:22.477Z    	

