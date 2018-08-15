<?hh // partial
require __DIR__ . '/../vendor/autoload.php';

class FileLoader {
  public function __construct(private string $api, private string $cacheFolder) {
  }

  public function isReady(): bool {
    $filenames = scandir($this->cacheFolder);
    return in_array("Full.txt", $filenames);
  }

  public async function process(): Awaitable<void> {
    await $this->deleteAll();
    await $this->insertAll($this->cacheFolder);
  }

  protected async function loadFiles(string $dir): Awaitable<Vector> {
    $dir = '/' . trim($dir, '/');
    $filenames = scandir($dir, SCANDIR_SORT_DESCENDING);
    $rst = Vector {};
    try {
      foreach ($filenames as $fn) {
        if (!in_array($fn, array('.', '..')) && strpos($fn, '(') === false) {
          foreach ($this->loadFile($dir . '/' . $fn) await as $record) {
            $rst[] = $record;
          }
          break;
        }
      }

      echo 'Loaded ' . count($rst) . ' records' . PHP_EOL;
    } catch (Exception $e){
      echo $e->getMessage() . PHP_EOL;
      return $rst;
    }

    foreach ($filenames as $fn) {
      if (!in_array($fn, array('.', '..'))) {
        echo 'Deleting file ' . $fn . PHP_EOL;
        unlink($dir . '/' . $fn);
      }
    }

    return $rst;
  }

  protected async function loadFile(string $filename): AsyncIterator<Map> {
    if (($file = fopen($filename, "r")) !== FALSE) {
        // Read the field names
        $field_names = fgetcsv($file, 0, "\t");
        $field_count = count($field_names);
        // Read records
        while (($data = fgetcsv($file, 0, "\t")) !== FALSE) {
            $record = Map {};
            // Create an associative array to read the record
            for ($ifield = 0; $ifield < $field_count; $ifield++) {
                $record[$field_names[$ifield]] = $data[$ifield];
            }
            // Add the record just read to the array of records
            yield $record;
        }

        fclose($file);
    }
  }

  protected async function deleteAll(): Awaitable<void> {
    $client = new GuzzleHttp\Client();
    try {
      $res = $client->request('DELETE', $this->api);
      echo 'DELETE status: ' . $res->getStatusCode() . PHP_EOL;
    }
    catch (\GuzzleHttp\Exception\ClientException $ex) {
      echo 'Already deleted' . PHP_EOL;
    }
  }

  protected async function insertAll(string $folder): Awaitable<void> {
    $rst = await $this->loadFiles($folder);
    // print_r(json_encode(array_slice($rst, 0, 2)));
    if (count($rst) > 0) {
      $client = new GuzzleHttp\Client();
      $res = $client->request('POST', $this->api, [
        'headers' => [
          'Content-Type' => 'application/json'
        ],
        'json' => $rst
      ]);

      echo 'INSERT status:' . $res->getStatusCode() . PHP_EOL;
    } else {
      echo 'No record to insert' . PHP_EOL;
    }
  }
}
