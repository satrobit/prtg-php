# prtg-php

Using this library you can get details on your sensors , create charts and more

## Install
### Using Composer
Add this package to your `composer.json`:
```json
"require": {
    "satrobit/prtg-php": "dev-master"
}
```
or by command line :
```bash
composer require satrobit/prtg-php
```
## Usage
You need to construct a client first.
~~~php
$client = new prtg(SERVER, USERNAME, PASSWORD);
~~~
like this:
~~~php
$client = new prtg('https://prtg.paessler.com/', 'demo', 'demo');
~~~
Now you can use these methods to interact with the API:

### Method: getsensordetails
This method returns details of a specified sensor

**Parameters:**
| Name | Type | Description |
|--|--|--|
| sensorId | int | Sensor ID in PRTG |

**Example:**
~~~php
$sensorDetails = $client->getsensordetails(2017);
~~~

### Method: historicdata
This method returns historic data on a specified sensor

**Parameters:**
| Name | Type | Description |
|--|--|--|
| sensorId | int | Sensor ID in PRTG |
| sdate | string | Starting date |
| edate | string | Ending date |
| avg | int | Average |

**Example:**
~~~php
$historicData = $client->historicdata('2017', '2017-07-26', '2017-07-27', 15);
~~~

### Method: chart
This method returns a chart of a specified sensor

**Parameters:**
| Name | Type | Description |
|--|--|--|
| sensorId | int | Sensor ID in PRTG |
| sdate | string | Starting date |
| edate | string | Ending date |
| graphid | int | Graph ID |
| type | string | Returned object type like svg, png |
| avg | int | Average |
| height | int | Height of the chart (px) |
| width | int | Width of the chart (px) |

**Example:**
~~~php
$chart = $client->chart(2017, '2017-07-26', '2017-07-27', 2, 'svg', 15, 270, 850);
~~~

## Examples

Check out [examples.php](examples.php) .

## License

This project is released under the [MIT](https://github.com/satrobit/prtg-php/blob/master/LICENSE) License.
