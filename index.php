<html>
    <head>
        <style>
            * {
                padding:1;
                margin:0;
            }
        
            html {
                width:99%;
                height:100%;
                padding:1;
                margin:0;
            }
            
            .box {
                width:100%;
                height:20%;
                display:grid;
                border:4px solid black;
                grid-template-columns: 1fr 1fr 1fr 1fr;
            }
            
            .buttons {
                display:grid;
                grid-template-rows: 1fr 1fr;
            }
            
            .buttons2 form {
                display:grid;
                grid-template-columns: 1fr 1fr;
            }
            
            .user-info {
                display:grid;
                grid-template-rows: 1fr 1fr 1fr;
            }
            
            form {
                width:100%;
                height:100%;
            }
            
            form *{
                width:100%;
                height:100%;
            }
        </style>
        
        <script>
            function kick(targetID) {
                window.location.href += "&action=kick&target=" + targetID
            }
            function decreaseRank(targetID) {
                window.location.href += "&action=decrease&target=" + targetID
            }
            function increaseRank(targetID) {
                window.location.href += "&action=increase&target=" + targetID
            }
       
            function myFunction() {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString)
                id = urlParams.get('id')
                window.location.href = "https://BASEURL/index.php?id="+id
            }
        </script>
    </head>
    
    <body>
        <?php 
        function remove_prefix($text, $prefix) {
    if(0 === strpos($text, $prefix))
        $text = substr($text, strlen($prefix)).'';
        return $text;
    }
                    $id = $_GET['id'];
                $post = [
        'id' => $id
    ];
            if (isset($_GET["action"])) {
                switch ($_GET["action"]) {
                    case "kick":
                        $post = [
                            'id' => $_GET["target"]
                        ];
                        $ch = curl_init('REMOVED LINK'); # removes member from guild
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        echo "<div id='redirect'>kicked successfully</div>";
                        break;
                        
                    case "decrease":
                        $post = [
                            'id' => $_GET["target"]
                        ];
                        $ch = curl_init('REMOVED LINK'); #gets guild info - example output: 5102|2|2022-02-19 23:42:17|  - breakdown: Guild ID|member position|last login date
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $data1 = explode("|",$response);
                        curl_close($ch);
                        
                        $post = [
                            'id' => $id,
                            'targetid' => $_GET["target"],
                            'guildidx' => strval($data1[0]),
                            'nextgrade' => strval($data1[1]-1)
                        ];
                        $ch = curl_init('REMOVED LINK'); #changes member position to set 'nextgrade' value
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        
                        echo "<div id='redirect'>decreased rank successfully</div>";
                        break;
                        
                    case "increase":
                        $post = [
                            'id' => $_GET["target"]
                        ];
                        $ch = curl_init('REMOVED LINK'); #gets guild info - example output: 5102|2|2022-02-19 23:42:17|  - breakdown: Guild ID|member position|last login date
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $data1 = explode("|",$response);
                        curl_close($ch);
                        
                        $post = [
                            'id' => $id,
                            'targetid' => $_GET["target"],
                            'guildidx' => strval($data1[0]),
                            'nextgrade' => strval($data1[1]+1)
                        ];
                        $ch = curl_init('REMOVED LINK'); #changes member position to set 'nextgrade' value
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        
                        echo "<div id='redirect'>increased rank successfully</div>";
                        break;
                }
            }

			#gets member list
            $ch = curl_init('REMOVED LINK');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
			/*    example output
			askljadskfadsn|양진환|0|2022-05-23|5|그랜드마스터3|
			aslkdsjaaad|졸린곰127|0|2022-05-08|4|언랭크3|
			asdjkfdsfasjk|Saturn1345|1|2022-03-23|5|데미갓5| 
			
			breakdown:
			member1 ID|member1 name|guild position|last login date|rank number|rank name
			member2 ID|member2 name|guild position|last login date|rank number|rank name
			member3 ID|member3 name|guild position|last login date|rank number|rank name
			*/
			
            
            $members = remove_prefix($response, "\n\n");
            $members = str_replace("\n\r\n\r\n", " ", $members);
            $members = explode("\n", $members);
            foreach ($members as $value){
                
                
                $memberInfo = explode("|", $value);
                
                $post = [
                    'id' => $memberInfo[0]
                ];
                $ch = curl_init('REMOVED LINK'); #gets account info - example output: zxc0|918173|헤루빔|3|78|875152|269536  - breakdown: username|experience|rank name|rank number|ability points|diamonds|tokens
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $userInfo = explode("|", $response);
                
                echo "<div class='box'><div class='buttons'><h3>Member Name: ".$memberInfo[1]."</h3>";
                switch($memberInfo[2]){
                    case "0":
                        $memberPlacement = "pending";
                        break;
                    case "1":
                        $memberPlacement = "private";
                        break;
                    case "2":
                        $memberPlacement = "seargent";
                        break;  #dont know the rest of the text equivalents of the member positions 3-8
                    case "9":
                        $memberPlacement = "owner";
                        break;
                    default:
                        $memberPlacement = "error";
                        break;
                }
                echo "<h3>current rank: ".$memberPlacement."</h3></div>";
                $timeSince = strtotime($memberInfo[3]) - time();
                echo "<div class='buttons'><h3>last login: ".$memberInfo[3]."</h3><h3>".abs(round($timeSince / (60 * 60 * 24)))." days since last login</h3></div>";
                
                
                echo "<div class='user-info'><h3 style='height:auto;'>current experience: ".$userInfo[1]."</h3>";
                echo "<h3 style='height:auto;'>current diamonds: ".$userInfo[5]."</h3>";
                echo "<h3 style='height:auto;'>current tokens: ".$userInfo[6]."</h3></div>";
                
                if ($memberInfo[2] != "9"){
                echo "<div class='buttons'><div class='buttons2'><form><button type='button' onclick='decreaseRank(\"".$memberInfo[0]."\")'>decrease rank</button><button type='button' onclick='increaseRank(\"".$memberInfo[0]."\")'>increase rank</button></form></div>";
                echo "<form><button type='button' onclick='kick(\"".$memberInfo[0]."\")'>Kick</button></form></div>";
            }
                echo "</div><br>\n";
            }
        ?>
        <script>
            if (document.getElementById("redirect") != null){
                document.getElementById("redirect").innerHTML = myFunction();
            }
        </script>
    </body>
</html>