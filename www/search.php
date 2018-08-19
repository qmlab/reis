<?hh // partial
require_once(__DIR__."/../vendor/hh_autoload.php");
require_once(__DIR__."/../adapters/db.php");

function search() {
  $config = parse_ini_file(__DIR__."/../config/server.ini");
  $db = new MongoClient($config["mongodb"], new GuzzleHttp\Client());
  $handle = $db->findAllByKeywords("Marketing Remarks", ["rental", "investment", "estate", "fixer", "sold as-is", "investing", "renting", "distressed", "tlc", "renovation"]);
  $lns = HH\Asio\join($db->project($handle, "Listing Number"));
  $head =
    <head>
      <meta charset="utf-8" />
      <title>REIS Mortgage Caldulator</title>
    </head>;
  $list =
    <table>
    </table>;
  foreach ($lns as $ln) {
    $tr =
      <tr>
        <td>{$ln}</td>
      </tr>;
    $list->appendChild($tr);
  }

  echo
    <html>
      {$head}
      <body>
        {$list}
      </body>
    </html>;
}

search();
