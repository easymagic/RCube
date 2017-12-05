# RCube

RCube uses the concept of packages to run a web app
you can create any package (folder) in the root directory
and mount that package by going to the config.php file
and editing the:

  define('PACKAGE_MOUNT', 'custom_app');

in this case, the package/folder name is 'custom_app'
and you can create as many classes as you want under that package
and the route is quite similar to what you have in frameworks like
code-igniter (controller/method/args)

To load a module, use the load_module function which takes the package-name
and the actual class-name.

Enjoy!!! 



