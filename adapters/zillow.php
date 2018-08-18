<?hh // partial
namespace Adapters;

require '../vendor/autoload.php';
// class WebClient {
//   private $client;
//   private static $db = "http://localhost:5000/homes";
//   private static $zUrl = "https://www.zillow.com/homes/";
//   public function __construct(): void {
//     $this->client = new GuzzleHttp\Client();
//   }
//
//   public async function connect(): Awaitable<void> {
//     $res = $this->client->request('GET', '', []);
//     echo $res->getStatusCode() . PHP_EOL;
//     // "200"
//     echo implode($res->getHeader('content-type')) . PHP_EOL;
//     // 'application/json; charset=utf8'
//     echo $res->getBody() . PHP_EOL;
//     // {"type":"User"...'
//     // await HH\Asio\usleep(1000000);
//     // print_r(time() . PHP_EOL);
//   }
//
//   public async function getZID(string addr): Awaitable<string> {
//     $encoded = urlencode(str_replace(' ', '-', addr)) . '_rb';
//     $res = $this->client->request('GET', WebClient::zUrl . $encoded);
//     echo $res->getStatusCode() . PHP_EOL;
//     // "200"
//     echo implode($res->getHeader('content-type')) . PHP_EOL;
//     // 'application/json; charset=utf8'
//     echo $res->getBody() . PHP_EOL;
//     // {"type":"User"...'
//     // await HH\Asio\usleep(1000000);
//     // print_r(time() . PHP_EOL);
//     return "";
//   }
// }
// //
// $wc = WebClient();
// HH\Asio\join($wc->getZID('13621 NE 136th Pl, KIRKLAND, WA 98034'));
