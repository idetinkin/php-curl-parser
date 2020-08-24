# Curl Parser

The simple way to generate a Curl object from the curl command intended for command line.

### Example of usage
If you want to simulate user actions on a third party site (acceptably only if the user trusts your service, or you are your user):
1. Open a web site where you want to simulate user actions
1. Open DevTools by pressing Control+Shift+J
1. Click the Network tab. The Network panel opens
1. Click the Doc tab
1. Refresh the page
1. Right-click on the request and select Copy -> Copy as cURL
1. Pass the text from clipboard to the PHP script

### Example of the PHP script

```php
$curlCommand = "curl 'https://www.google.com/?gws_rd=ssl' \
    -H 'authority: www.google.com' \
    -H 'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36' \
    --compressed";

$curl = (new \curlParser\Parser($curlCommand))->getCurlObject();
$html = $curl->exec();
```

### Supported attributes
* -H or --header
* --compressedx
