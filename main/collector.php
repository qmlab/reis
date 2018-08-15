<?hh // partial
require __DIR__ . '/../ingestion/matrix.php';

async function main(array<string> $argv): Awaitable<void> {
  $api = $argv[1];
  $srcDir = $argv[2];
  $destDir = __DIR__ . "/../cache";

  $loader = new FileLoader($api, $destDir);
  while (true) {
    $doneCp = await prepareFiles($srcDir, $destDir);
    if ($doneCp && $loader->isReady()) {
      l("Processing starts.");
      await $loader->process();
      l("Processing completes.");
    }
    await HH\Asio\usleep(5000000);
  }
}

async function prepareFiles(string $srcDir, string $destDir): Awaitable<bool> {
  if (!file_exists($srcDir)) {
    l("Directory " . $srcDir . " does not exist.");
    return false;
  }
  if (!file_exists($destDir)) {
    mkdir($destDir);
  }

  $filenames = scandir($srcDir);
  foreach ($filenames as $fn) {
    if (substr($fn, 0, 4) === "Full" && substr($fn, -4) === ".txt") {
      copy(combine($srcDir, $fn), combine($destDir, $fn));
      l("Source data file copied to cache folder");
      unlink(combine($srcDir, $fn));
      l("Source data file deleted");
    }
  }

  return true;
}

function combine(string $dir, string $fn): string {
  return rtrim($dir, "/") . "/" . $fn;
}

// Logging. Now to console.
// TODO: change to other implementations later
function l(string $msg) {
  print_r("[" . date(DATE_RFC2822) . "]" . $msg . PHP_EOL);
}

HH\Asio\join(main($argv));
