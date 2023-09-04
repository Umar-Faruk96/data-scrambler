<?php
declare(strict_types=1);
include_once "scrambleFunctions.php";

$key = "abcdefghijklmnopqrstuvwxyz1234567890";
$mode = $_GET["mode"] ?? "encode";
// ! key generator logic
if ("key" === $mode) {
    $original_keys = str_split($key);
    shuffle($original_keys);
    $key = join("", $original_keys);
} elseif (!empty($_POST["key"])) {
    $key = $_POST['key'];
}

// ! encode logic
$scrambledData = "";
if ("encode" === $mode) {
    $inputData = $_POST["inputData"] ?? "";
    if ($inputData !== "" && !empty($inputData)) {
        $scrambledData = encodeData($inputData, $key);
    }
}

// ! decode logic
if ("decode" === $mode) {
    $inputData = $_POST["inputData"] ?? "";
    if ($inputData !== "" && !empty($inputData)) {
        $scrambledData = decodeData($inputData, $key);
    }
}
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8" />
    <title>Data Scrambler Application</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
    <style>
        body {
            margin-top: 30px;
        }

        #result {
            width: 100%;
            height: 80px;
        }
    </style>
</head>

<body>
    <!-- ! PHP Form Tutorial by Hasin Hayder -->
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2 id="display">Project 1: Data Scrambler</h2>
                <p>Use this application to scramble your data</p>
                <p>
                    <!-- // ! look out the path carefully-->
                    <a href="/hasin haider/Scramble Data/index.php?mode=encode">Encode</a> |
                    <a href="/hasin haider/Scramble Data/index.php?mode=decode">Decode</a> |
                    <a href="/hasin haider/Scramble Data/index.php?mode=key">Generate Key</a>
                </p>
            </div>

        </div>

        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php<?php if ("decode" === $mode) {
                    echo "?mode=decode";
                } ?>" method="post">
                    <label for="key">Key</label>
                    <input type="text" name="key" id="key" value="<?= displayKey($key) ?>" />
                    <label for="inputData">Input Data</label>
                    <textarea name="inputData" id="inputData"><?php if (isset($_POST["inputData"])) {
                        echo $_POST["inputData"];
                    } ?></textarea>
                    <label for="result">Result</label>
                    <textarea name="result" id="result"><?= $scrambledData ?></textarea>

                    <button type="submit">Do It For Me</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>