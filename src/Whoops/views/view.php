<!DOCTYPE html>
<html>
<head>
  <title>An error has occurred</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/styles/default.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/highlight.min.js"></script>
  <script>hljs.initHighlightingOnLoad();</script>
  <style type="text/css">
    .line {
  margin-left: -10px;
  background: rgba(0, 0, 0, .14);
  padding: 2px 2px;
  margin-top: -1px;
  margin-right: 14px;
  width: 44px;
  display: inline-table;
  text-align: center;
  }

  </style>
</head>
<body>
    <div class="">
        <div class="container">
            <div>
                <h5>Message:</h5>
                <p><?php echo isset($stack['message']) ? $stack['message'] : '<span style="color:red">Sorry, message not found</span>' ?></p>
            </div>
            <div>
              <h5>Code:</h5>
              <p><span style='color:red'>File: </span><?php echo isset($stack['file']) ? $stack['file'] : '<span style="color:red">Sorry, message not found</span>' ?></p>
              <p><?php
                $uri = $stack['editorUri'];
                $uri = str_replace('::file', $stack['file'], $uri);
                $uri = str_replace('::line', $stack['line'], $uri);
               echo (!empty($stack['editor'])) ? "<a href='{$uri}'>Open file in ".$stack['editor'].' editor</a>' : ''; ?></p>

              <pre><code class=""><?php echo isset($stack['previewCode']) ? $stack['previewCode'] : '<span style="color:red">Sorry, code not loaded</span>' ?></code></pre>
            </div>
            <div>
              <h5>Trace:</h5>
              <pre><?php echo isset($stack['trace']) ? $stack['trace'] : '<span style="color:red">Sorry, message not found</span>' ?></pre>
            </div>
        </div>
    </div>
</body>
</html>
