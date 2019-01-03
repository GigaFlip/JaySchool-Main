<?php
 
use google\appengine\api\cloud_storage\CloudStorageTools;
 
$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
$root_path = 'gs://' . $bucket . '/' . $_SERVER["REQUEST_ID_HASH"] . '/';
 
$public_urls = [];
foreach($_FILES['userfile']['name'] as $idx => $name) {
  $original = $root_path . 'original/' . $name;
  move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original);
 
  $public_urls[] = [
        'name' => $name,
        'original' => CloudStorageTools::getPublicUrl($original, false),
  ];
} 
 
?>
<html>
<body>
<?php
foreach($public_urls as $urls) {
  echo '<a href="' . $urls['original'] .'">File</a>';
  echo '<p>';
}
?>
<p>
<a href="/direct_upload">Upload More</a>
</body>
</html>