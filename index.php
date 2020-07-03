<?php

const API_KEY = 'f7a19678';
const API_URL = 'http://www.omdbapi.com';

/**
 * construct url to call
 * @param string searchvalue
 * @return string
 */
function constructSearchUrl($searchValue)
{
    return API_URL . '/?apikey=' . API_KEY . '&s=' . $searchValue . '&page=1';
}

/** default search to red on iniital load  */
$searchValue = isset($_GET['search']) ? $_GET['search'] : 'red';
$searchUrl = constructSearchUrl($searchValue);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $searchUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers[] = "Accept: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

/** Throw error and return if any error in fetching details */
if (curl_errno($ch)) {
    print 'There was some error in fetching details, Please try again later. Error code :' . curl_error($ch);
    return;
}

$moviesResult = json_decode(curl_exec($ch));
curl_close($ch);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Developer Test</title>
    <meta name="description" content="The developer test">
    <meta name="author" content="SitePoint">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
</head>

<body>
    <div class="form-container">
        <select id="select" name="search" class="dropdown">
            <option value="red" <?php print $_GET['search'] === 'red' ? 'selected' : '' ?>>Red</option>
            <option value="green" <?php print $_GET['search'] === 'green' ? 'selected' : '' ?>>Green</option>
            <option value="blue" <?php print $_GET['search'] === 'blue' ? 'selected' : '' ?>>Blue</option>
            <option value="yellow" <?php print $_GET['search'] === 'yellow' ? 'selected' : '' ?>>Yellow</option>
        </select>
    </div>
    <?php if (isset($moviesResult->Response) && $moviesResult->Response == 'True') { ?>
        <div class="container">
            <?php foreach ($moviesResult->Search as $key => $movie) { ?>
                <div class="movie">
                    <div class="movie-img">
                        <img src="<?php print $movie->Poster ?>" alt="<?php print $movie->Title ?>">
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title">Title : <?php print $movie->Title ?></h3>
                        <div class="movie-details">
                            <p>Imdb ID : <?php print $movie->imdbID ?></p>
                            <p>Year : <?php print $movie->Year ?></p>
                            <p>First : <?php print substr($movie->Title, 0, strpos($movie->Title, ' ')) ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>
            Some error occoured, Error reason:
            <?php print isset($moviesResult->Error) ? $moviesResult->Error : 'Not sure' ?>
        </p>
    <?php } ?>
    <script src="js/scripts.js"></script>
</body>

</html>