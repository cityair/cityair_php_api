Модуль для работы с CityAirAPI:
--------------------------

* для подключения и работы модуля необходимо подключить файл в рабочем окружении и указать данные своего аккаунта

    	require_once("CityAirAPI.php");
    	$CAApi = new CityAirAPI();
    	$CAApi->login ='YOUR_LOGIN';
    	$CAApi->password = 'YOUR_PASSWORD';

* информация с определенного устройства, где SERIAL_NUMBER = серийный номер устройства

    	$CAApi->getDeviceBySerial('SERIAL_NUMBER');

* информация обо всех устройствах 
 
        $CAApi->getDevices();
    
* получение информации о пакетах с выбранной станции с фильтром по параметрам

        $serial = 'SERIAL_NUMBER';
    	$filter = [
    	  "TimeBegin"       => '',
    	  "TimeEnd"         => '',
    	  "Take"            => ''
    	];
    	$CAApi->getPackets($serial, $filter);
    "BeginTime" и "EndTime" указываются в формате ISO 
        
        2018-06-04T09:31:22.477Z    	
    "Take" - количество пакетов от станции. По умолчанию 10000.
