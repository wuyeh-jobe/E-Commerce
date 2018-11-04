
</div>
        </div>
        <div id="footer" style="background: #3D3D3D; text-align:center">
            <?php
                $path = explode("\\", getcwd());
                if ($path[sizeof($path)-1]=="pages"){
                    echo '<div style="padding-top:20px"><a target="_blank" href="https://www.facebook.com/GamFruits-1826542117618203/" style="color:#EBEBEB"><img class="media" src="../image/facebook.jpg"></a><a target="_blank" href="https://twitter.com/GamFruits" style="color:#EBEBEB"><img class="media" src="../image/Twitter.jpg"></a><a target="_blank" href="#" style="color:#EBEBEB"><img class="media" src="../image/Youtube.jpg"></a> </div>';
                }
                else{
                   echo '<div style="padding-top:20px"><a target="_blank" href="https://www.facebook.com/GamFruits-1826542117618203/" style="color:#EBEBEB"><img class="media" src="image/facebook.jpg"></a><a target="_blank" href="https://twitter.com/GamFruits" style="color:#EBEBEB"><img class="media" src="image/Twitter.jpg"></a><a target="_blank" href="#" style="color:#EBEBEB"><img class="media" src="image/Youtube.jpg"></a> </div>';
                }
            ?>
            <div id="copyright" style="color:#EBEBEB">© 2018 · All Rights Reserved · GamFruits </div>
        </div>
    </div>
</body>
</html>