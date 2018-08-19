<?hh // partial
require_once(__DIR__."/../vendor/hh_autoload.php");

class MongoClient {
    public function __construct(private $db, private $client): void {
    }

    public async function find(string $filter = ""): AsyncIterator<array> {
      $page = 1;
      $subrst = await $this->findInternal($filter, $page);
      while (count($subrst) > 0) {
        yield $subrst;
        $page++;
        $subrst = await $this->findInternal($filter, $page);
      }
    }

    public async function findAll(string $filter = ""): Awaitable<array> {
      $itr = $this->find($filter);
      $rst = [];
      foreach ($itr await as $pageRst) {
        $rst = array_merge($rst, $pageRst);
      }

      return $rst;
    }

    // find all by marketing remarks keywords
    <<__Memoize>>
    public async function findAllByKeywords(string $field, array $keywords): Awaitable<array> {
      $combined = implode("|", $keywords);
      $filter = "\"$field\":{\"\$regex\":\".*$combined.*\", \"\$options\": \"i\"}";
      $rst = await $this->findAll($filter);
      return $rst;
    }

    // project result to a selected field
    // return - array of values
    public async function project(Awaitable<array> $rstHandle, string $field): Awaitable<array> {
      $arr = await $rstHandle;
      $rst = [];
      foreach ($arr as $r) {
        $rst[] = $r->$field;
      }
      return $rst;
    }

    protected async function findInternal(string $filter = "", int $page = 1): Awaitable<array> {
      $res = $this->client->request('GET', $this->db . "?max_results=200&page=$page&where={" . $filter . "}");
      $json = json_decode($res->getBody() . PHP_EOL);
      return $json->_items;
    }
}

// Examples:
// $db = new MongoClient("localhost:5000/homes", new GuzzleHttp\Client());
//
// 1.Get all results by regex
// HH\Asio\join($db->findAll("\"Exterior\":{\"\$regex\":\".*Stucco.*\"}"));
//
// 2.Get all by keywords in any field and project to any field
// $handle = $db->findAllByKeywords("Marketing Remarks", ["Rental", "Investment"]);
// HH\Asio\join($db->project($handle, "Listing Number"));
