<?php
//Needed varibles
//you need to put a roblox cookie here blame roblox
$cookie = "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_6F7E98968B6AC1312C4D93CEDA24CAB5FC4F581C3033AE0AAB3DD4A74A94AD69F6E97D1BC81772CC23FDF5455795BE9F6F6D8DB3F249250FB78D6DC5393485DCE43F948499A27F36D02E0E84D67955090DCACBBA82B08E9E67DD47BB150C6F6444A1BCE1164DC399460EEAF102D1160CCA16178C41187652B77F6DB42C46E5D9FB2221903B590408B0CF2D33F58B2E757BC26B162F298512F147014F15243C81788214684D4DA41062D992FD8939977F18BCB52C1A41A7BDC399664E771B1CB0908CDEB7F14C049808A9635D0E5DF1FDFB038FAB48B86C2B53C4C070D594D71C2029444193DF2424D077360A45E1DCFAB7A40D3F1D96D8A8F98DDCA488CC946B4EE0415ABFBF69CFF7BBF16E75A3D2D6890D8FCEC67BCCE6AD4C869DDE51055299D0D14361DF2C709FD40EDCBE663652CB85D247F65BAE4469D64D43D73BFC5EB4CEF3E2DCB98291DCCE578367440E67195EECFA3100EF00A45D7DDFB6FF8543F515C46DE54B57480598CD857266DBF989D0D3041A5DF0B4276E92338C94DBEB0FAADA484617C6C8D4D8E8158BABC4AD43ED92D5A824C650AE70FE45C5B048BDEB3C1707415431EEDAE8696612C5B25844A5CD85258D07C29A5AF981CBC556127E70E490";
$pageName = "Condos";
$blurAmount = "10px";
$backgroundImage = "https://www.teahub.io/photos/full/11-111196_gif-wallpaper.gif";
$discordInvite = "https://discord.gg/mxrTffZZSw";
$iconUrl = "https://images.rbxcdn.com/3b43a5c16ec359053fef735551716fc5.ico"; // Icon of the site
$webhook = "https://discord.com/api/webhooks/1145833853739597987/PZhGJkthqTYxW5lU0qE550lYxDX7iIApCTdANZzDUbBLxKgxY9D3VAUIxMHjXCLDhOkE"; // Out of games and error webhook

$gameIds = array(// List of gamesIDs
    6674398905,
);

$githubCredits = false; //Add in the bottom right my github link

//Embed data
$enableEmbed = True; //IDK if i made the toggle right lol
$embedHexColor = "#85bb65"; //Needs to be hex code
$embedTitle = "Condos"; //Title for embed
$embedDescription = "List of Condos"; //Description for embed

// /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
// | DON'T MESS WITH ANY THING PAST UNLESS YOU KNOW WHAT YOU ARE DOING! |
// \____________________________________________________________________/

//Discord out of games and error webhook
function postToDiscord($message){
    $json_data = json_encode(["content" => $message], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( $webhook );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec( $ch );
    curl_close( $ch );
}
shuffle($gameIds);

function sendCsrfRequest(){ //Send a request to get the CSRF token from roblox
    $csrfUrl = "https://auth.roblox.com/v2/login";

    function grabCsrfToken( $curl, $header_line ) { //Filter through the Roblox headers
        if(strpos($header_line, "x-csrf-token") !== false){
            global $csrf;
            $csrf = ltrim($header_line, "x-csrf-token: "); // set x-csrf-token var
        }
        return strlen($header_line);
    }

    $csrfCurl = curl_init();
    curl_setopt($csrfCurl, CURLOPT_URL, $csrfUrl);
    curl_setopt($csrfCurl, CURLOPT_POST, true);
    curl_setopt($csrfCurl, CURLOPT_HEADERFUNCTION, "grabCsrfToken");
    curl_setopt($csrfCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($csrfCurl,CURLOPT_RETURNTRANSFER,1);

    curl_exec($csrfCurl);
    curl_close($csrfCurl);
}

function checkGame($placeId){ //Finds what game works
    global $csrf, $cookie, $isPlayable;
    $gameUrl = "https://games.roblox.com/v1/games/multiget-place-details?placeIds=$placeId";

    $gameCurl = curl_init();
    curl_setopt($gameCurl, CURLOPT_URL, $gameUrl);

    $headers = array("X-CSRF-TOKEN: ".$csrf);
    curl_setopt($gameCurl, CURLOPT_COOKIE, '.ROBLOSECURITY='.$cookie);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($gameCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($gameCurl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($gameCurl, CURLOPT_RETURNTRANSFER,1);

    $resp = curl_exec($gameCurl);
    curl_close($gameCurl);
    $data = json_decode($resp);
    return $data[0]->isPlayable; //Get if you can play or not
}
try {
    sendCsrfRequest();
} catch (Error $e) {}
$versionId = "1.0.2"
?>
<!DOCTYPE html>
<html lang='en'>
	<head>
		<meta charset='UTF-8'/>
		<title>
                <?php echo($pageName); ?>
		</title>
        <link rel="icon" href="<?php echo($iconUrl); ?>">
	    <style>
	    	@import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
	    	@import url('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');

	    	@keyframes glowing {
	    		0% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    		50% {
                    filter: drop-shadow(0 0 0.50rem green);
	    		}
	    		100% {
                    filter: drop-shadow(0 0 0.25rem red);
	    		}
	    	}

	    	body {
    			background: url("<?php echo($backgroundImage); ?>") no-repeat center center fixed; 
				background-repeat: no-repeat;
				backdrop-filter: blur(<?php echo($blurAmount); ?>);
				background-position: bottom;
				background-size: cover;

				height: 100vh;
				width: 100%;

	    		font-family: 'Montserrat', sans-serif;
	    		min-height: 80vh;
	    		display: -webkit-box;
	    		display: flex;
	    		align-items: center;
	    		justify-content: center;
	    		flex-direction: column;
	    	}

	    	h1 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-weight: bold;
                filter: drop-shadow(0 0 0);
	    		animation: glowing 3500ms infinite;
	    	}

	    	h2 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 350%;
	    	}

	    	h3 {
	    		font-family: 'Montserrat', sans-serif !important;
	    		font-size: 150%;
	    	}

            #bottomRight
            {
                position:fixed;
                bottom:5px;
                right:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
            #bottomLeft
            {
                position:fixed;
                bottom:5px;
                left:5px;
                opacity:0.5;
                z-index:99;
                color:white;
            }
	    </style>

        <script>
            function fadeInPage() {
                for (let i = 1; i < 100; i++) {
                    fadeIn(i * 0.01);
                }
            
                function fadeIn(i) {
                    setTimeout(function() {
                        document.body.style.opacity = i;
                    }, 2000 * i);
                }
            }
        </script>
        <?php if ($enableEmbed): ?>
        <meta name="description" content="<?php echo($embedDescription);?>">

        <!-- Google / Search Engine Tags -->
        <meta name="theme-color" content="<?php echo($embedHexColor);?>">
        <meta itemprop="name" content="<?php echo($embedTitle);?>">
        <meta itemprop="description" content="<?php echo($embedDescription);?>">

        <!-- Facebook Meta Tags -->
        <meta property="og:title" content="<?php echo($embedTitle);?>">
        <meta property="og:type" content="website">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo($embedTitle);?>">
        <meta name="twitter:description" content="<?php echo($embedDescription);?>">
        <?php endif; ?>
        
	</head>

	<body style="opacity:0" onload='fadeInPage()'>
		<h1 class="text-light">
                <?php echo($pageName); ?>
		</h1>
        <?php if ($discordInvite !== "https://discord.gg/"): ?>
        <div class="btn-group mt-2 mb-4" role="group" aria-label="actionButtons">
			<a href="<?php echo($discordInvite); ?>" class="d-block btn btn-outline-light">
				Join the Discord
			</a>
		</div>
        <?php endif; ?>
        <a>
            <?php
                try {
                    foreach ($gameIds as $gameId) {
                        echo "<h3 class=\"text-light\">";
                        $isPlayable = checkGame($gameId);
                        echo "<b>$gameId:</b> ";
                        if ($isPlayable){
                            echo "<a style=\"color: #dcdcdc\" href=\"https://www.roblox.com/games/$gameId\"><u>Click for game</u></a><br>";
                        }else{
                            echo "Game banned<br>";
                        }
                        echo "</h3>";
                    }
                } catch (Error $e) {
                }
            ?>
            <div id="bottomLeft"> <?php //Please don't take credit for this shit :) ?>
                V<?php echo($versionId); ?>
            </div>

            <?php if ($githubCredits): ?>
            <div id="bottomRight"> <?php //Please don't take credit for this shit :) ?>
                <a href="https://github.com/Roblox-Thot/cashmoney-con.tk">
                    Site coded by Roblox Thot
                </a>
            </div>
            <?php endif; ?>
		</a>
    </body>
</html>
</html>
