<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($stack['message']) ? $stack['message'] : 'Error something went wrong' ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/styles/default.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/highlight.min.js"></script>
  <script>hljs.initHighlightingOnLoad();</script>
<style type="text/css">
/* width */
::-webkit-scrollbar {
  width: 10px;
}
::-webkit-scrollbar-track {
  background: #fff;
}
::-webkit-scrollbar-thumb {
  background: #473b61;
}
body {
    margin: 0;
    padding: 0;
    width: 100%;
    background: lightgray;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}
.space {
    padding: 30px;
}
.main {
    width: 100%;
}
section .one {
    background: #fff;
    width: 90%;
    margin-left: 4%;
}
section .one .container {
    padding: 25px;
}
section .one p {
    border-bottom: 1px solid black;
}
section .one h3 {
    font-weight: 500;
    font-size: 30px;
    color: #999999;
}
section .one a {
    color: #999999;
}
section .one a:hover {
    color: #6e6e6e!important;
}
section .solution {
    background: #59ffba;
    width: 90%;
    margin-left: 4%;
    padding: 12px 0 12px 0;
}
section .solution .container {
    padding: 25px;
}
section .solution h3 {
    font-weight: 500;
    font-size: 30px;
}
section #tab {
    background: #fff;
    width: 90%;
    margin-left: 4%;
}
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #473b61;
  color: #fff;
  padding: 12px 35px 12px 35px;
}
.tab a {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
  text-decoration: none;
  color: #fff;
  margin-left: 50px;
}
.tab a:hover {
  background-color: #433366;
}
.tab a.active {
  background-color: #302842;
}
.tabcontent {
  display: none;
  padding: 6px 12px;
  -webkit-animation: fadeEffect 1s;
  animation: fadeEffect 1s;
}
@-webkit-keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}
@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}
.definition {
    padding: 25px 12px 12px 35px;
    margin-left: 300px;
}
.border:before {
    content: '';
}
.border {
    border-bottom: 1px solid red;
}
.definition-list-title {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: #473b61;
    margin-left: 118px;
}
.definition-list {
    display: grid;
    grid-column-gap: 1.5rem;
    grid-row-gap: 0.5rem;
    padding: 0.5em;
}
.definition-label {
    color: rgba(30, 20, 70, 0.5);
    word-wrap: break-word;
    line-height: 1.25;
    float: left;
    word-wrap: break-word;
    width: 100px;
}
.definition-label:after {
    content: ":";
}
.definition-value {
    color: #473b61;
    word-break: break-all;
    margin-bottom: 1rem;
    line-height: 1.25;
    margin: -27px 0 0 110px;
    padding: 0 0 0.5em 0;
}
#toggleBtn {
    margin-left: 75px;
    background: #59ffba;
    padding: 5px;
    text-decoration: none;
    color: #000;
    border: 1px solid transparent;
    border-radius: 30%;
}
@media only screen and (max-width: 915px) {
    .definition {
        padding: 25px 12px 12px 35px;
        margin-left: 30px;
    }
    .definition-list-title {
        margin-left: 18px;
    }
    .definition-label {
    }
    .definition-value {
        margin: 0 0 0 22px;
    }
}
.line {
  margin-left: -10px;
  padding: 2px 2px;
  margin-top: -1px;
  margin-right: 14px;
  width: 44px;
  display: inline-table;
  text-align: center;
}
.code pre code {
  height: 300px;
  overflow: auto;
}
</style>
<html>
</head>
<body>
    <section class="main">
        <span class="space"></span>
        <section class="one">
            <div class="container">
                <p><?=route('root')?></p>
                <h3><?php echo isset($stack['message']) ? $stack['message'] : '<span style="color:red">Sorry, message not found</span>' ?></h3>
                <a href="#!"><?php echo isset($stack['message']) ? $stack['requests']['baseUrl'] : '' ?></a>
            </div>
        </section>
        <!-- TODO
            <section class="solution" id="solutionId">
            <a href="#!" onclick="toggleSolution()" id="toggleBtn">Hide solution</a>
            <div class="container" id="solution">
                <h3>Test</h3>
                <p>Test</p>
            </div>
        </section>
        -->
        <section id="tab">
            <nav class="tab">
              <a href="#!" class="tablinks active" onclick="openTab(event, 'trace')">Stack trace</a>
              <a href="#!" class="tablinks" onclick="openTab(event, 'request')">Request</a>
              <a href="#!" class="tablinks" onclick="openTab(event, 'user')">User</a>
              <a href="#!" class="tablinks" onclick="openTab(event, 'environment')">Environment</a>
        <a href="#!" class="tablinks" onclick="openTab(event, 'traces')">Traces</a>
            </nav>

            <div id="trace" class="tabcontent" style='display: block;'>
              <div class='code'>
                <pre><code class=""><?php echo isset($stack['previewCode']) ? $stack['previewCode'] : '<span style="color:red">Sorry, code not loaded</span>' ?></code></pre>
        </div>
            </div>
            <div id="request" class="tabcontent">
                <div class="definition">
                    <h3 class="definition-list-title">Request</h3>
                    <dl class="definition-list">
                        <dt class="definition-label">URL</dt>
                        <dd class="definition-value"><?php echo isset($stack['requests']['url']) ? $stack['requests']['url'] : '...' ?></dd>
                        <dt class="definition-label">Method</dt>
                        <dd class="definition-value"><?php echo isset($stack['requests']['method']) ? $stack['requests']['method'] : '...' ?></dd>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Headers</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['headers'])) {
    foreach ($stack['requests']['headers'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Query String</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['query_string'])) {
    foreach ($stack['requests']['query_string'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Body</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['body'])) {
    foreach ($stack['requests']['body'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Files</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['files'])) {
    foreach ($stack['requests']['files'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Sessions</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['session'])) {
    foreach ($stack['requests']['session'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
                <hr>
                <div class="definition">
                    <h3 class="definition-list-title">Cookies</h3>
                    <dl class="definition-list">
                        <?php if (is_array($stack['requests']['cookies'])) {
    foreach ($stack['requests']['cookies'] as $key => $value) {
        ?>
                                <dt class="definition-label"><?=$key?></dt>
                                <dd class="definition-value"><?= $value ?> </dd>
                            <?php
    }
} else {?> ... <?php } ?>
                    </dl>
                </div>
            </div>
            <div id="user" class="tabcontent" style='height: 400px'>
              <div class="definition">
                  <h3 class="definition-list-title">Client information</h3>
                  <dl class="definition-list">
                      <dt class="definition-label">IP</dt>
                      <dd class="definition-value"><?php echo isset($stack['requests']['ip']) ? $stack['requests']['ip'] : '...' ?></dd>
                      <dt class="definition-label">User agent</dt>
                      <dd class="definition-value"><?php echo isset($stack['requests']['user_agent']) ? $stack['requests']['user_agent'] : '...' ?></dd>
                  </dl>
              </div>
            </div>
            <div id="environment" class="tabcontent" style='height: 300px'>
              <div class="definition">
                  <h3 class="definition-list-title">Environment information</h3>
                  <dl class="definition-list">
                      <dt class="definition-label">Zest version</dt>
                      <dd class="definition-value"><?php echo isset($stack['environment']['ZestVersion']) ? $stack['environment']['ZestVersion'] : '...' ?></dd>
                      <dt class="definition-label">PHP version</dt>
                      <dd class="definition-value"><?php echo isset($stack['environment']['PHPVersion']) ? $stack['environment']['PHPVersion'] : '...' ?></dd>
                  </dl>
              </div>
            </div>
            <div id="traces" class="tabcontent">
              <div class="definition">
                  <h3 class="definition-list-title">Traces</h3>
                      <?php if (is_array($this->stack['traces'])) {
    foreach ($this->stack['traces'] as $key => $value) {
        foreach ($value as $k => $v) {
            if (!is_array($k) && !is_array($v)) { ?>
                    <dl class="definition-list">
                      <dt class="definition-label"><?=$k?></dt>
                      <dd class="definition-value"><?= $v ?> </dd>
                      </dl>
                    <?php }
        } ?>
                       <hr>
                 <?php
    }
} ?>
                  </dl>
              </div>
            </div>
        </section>
    </section>
</body>
<script>
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
function toggleSolution() {
  var x = document.getElementById("solution");
  if (x.style.display === "none") {
      document.getElementById('toggleBtn').innerHTML = 'Hide solution';
      document.getElementById('solutionId').style.backgroundColor = "#59ffba";
    x.style.display = "block";
  } else {
      document.getElementById('toggleBtn').innerHTML = 'Show solution';
      document.getElementById('solutionId').style.backgroundColor = "#fff";
    x.style.display = "none";
  }
}
</script>
</html>