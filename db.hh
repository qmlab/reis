<?hh // partial

require 'vendor/autoload.php';
async function connect(): Awaitable<void> {
  $client = new GuzzleHttp\Client();
  $res = $client->request('GET', 'http://localhost:5000/homes', []);
  echo $res->getStatusCode() . PHP_EOL;
  // "200"
  echo implode($res->getHeader('content-type')) . PHP_EOL;
  // 'application/json; charset=utf8'
  echo $res->getBody() . PHP_EOL;
  // {"type":"User"...'
  // await HH\Asio\usleep(1000000);
  // print_r(time() . PHP_EOL);
}

async function getZID(string addr): Awaitable<string> {
  
}

HH\Asio\join(connect());
