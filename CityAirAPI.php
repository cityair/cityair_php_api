<?php

	class CityAirAPI
	{
		//		private $baseUrl = 'https://cityair.io/backend-api/request.php?map=/DevicesApi/';
		//		private $baseUrl = 'https://cityair.io/backend-api/request.php?map=/DevicesApi2/';
		private $baseUrl = 'https://develop.cityair.io/backend-api/request-dev-pg.php?map=/DevicesApi2/';
		public  $login;
		public  $password;

		private function getData($url, $args = NULL) {
			$options                     = [
			  CURLOPT_URL            => $url,
			  //			  CURLOPT_USERPWD => "$this->login:$this->password",
			  //			  CURLOPT_XOAUTH2_BEARER => "$this->token",
			  CURLOPT_HTTPHEADER     => [
				'Content-Type: application/json',
				'Accept: application/json',
			  ],
			  CURLOPT_CUSTOMREQUEST  => 'POST',
			  CURLOPT_RETURNTRANSFER => TRUE,
			];
			$data                        = [
			  "User"   => $this->login,
			  "Pwd"    => $this->password,
			  "Filter" => $args,
			];
			$json_args                   = json_encode($data);
			$options[CURLOPT_POSTFIELDS] = $json_args;

			$ch = curl_init();
			curl_setopt_array($ch, $options);

			$content = curl_exec($ch);
			$status  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($content && $out = json_decode($content)) {
				if ($status > 399) {
					throw new Exception($status);
				}
				if ($out->IsError) {
					throw new Exception($out->ErrorMessage);
				}
			}
			curl_close($ch);
			return $out->Result ? : FALSE;
		}

		public function getDevices() {
			return $this->getDeviceBySerial();
		}

		public function getDeviceBySerial($deviceId = NULL) {
			$url      = $this->baseUrl . 'GetDevices';
			$data     = [
			  "SerialNumber" => $deviceId,
			];
			$response = $this->getData($url, $data);
			return $response;
		}

		public function getPackets($serial, $filter) {
			$deviceData = $this->getDeviceBySerial($serial);
			//			$packetsValueTypes = $deviceData->PacketsValueTypes;
			$deviceId             = $deviceData->Devices[0]->DeviceId;
			$filter['FilterType'] = 1;
			$filter['DeviceId']   = $deviceId;
			$url                  = $this->baseUrl . 'GetPackets';
			$packets              = ($this->getData($url, $filter))->Packets;
			$out                  = [];
			foreach ($packets as &$packet) {
				$newData         = [];
				$newData['date'] = $packet->SendDate;
				foreach ($packet->Data as $data) {
					foreach ($deviceData->PacketsValueTypes as $packetType) {
						if ($data->VT == $packetType->ValueType) {
							$newData[$packetType->TypeName] = $data->V . $packetType->Measurement;
							break;
						}
					}
				}
				$out[] = $newData;
			}
			return $out;
		}
	}