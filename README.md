ExceptionsLib
==============

**ExceptionsLib** is a simple-to-use PHP component that simplifies error handling in your PHP apps and components.

System-Wide Installation
------------------------

ExceptionsLib should be installed using the [PEAR Installer](http://pear.php.net). This installer is the PHP community's de-facto standard for installing PHP components.

    sudo pear channel-discover pear.phix-project.org
    sudo pear install --alldeps phix/ExceptionsLib

As A Dependency On Your Component
---------------------------------

If you are creating a component that relies on ExceptionsLib, please make sure that you add ExceptionsLib to your component's package.xml file:

```xml
<dependencies>
  <required>
    <package>
      <name>ExceptionsLib</name>
      <channel>pear.phix-project.org</channel>
      <min>1.0.0</min>
      <max>1.999.9999</max>
    </package>
  </required>
</dependencies>
```

Usage
-----

The best documentation for ExceptionsLib are the unit tests, which are shipped in the package.  You will find them installed into your PEAR repository, which on Linux systems is normally /usr/share/php/test.

Development Environment
-----------------------

If you want to patch or enhance this component, you will need to create a suitable development environment. The easiest way to do that is to install phix4componentdev:

    # phix4componentdev
    sudo apt-get install php5-xdebug
    sudo apt-get install php5-imagick
    sudo pear channel-discover pear.phix-project.org
    sudo pear -D auto_discover=1 install -Ba phix/phix4componentdev

You can then clone the git repository:

    # ExceptionsLib
    git clone git@github.com:stuartherbert/ExceptionsLib.git

Then, install a local copy of this component's dependencies to complete the development environment:

    # build vendor/ folder
    phing build-vendor

To make life easier for you, common tasks (such as running unit tests, generating code review analytics, and creating the PEAR package) have been automated using [phing](http://phing.info).  You'll find the automated steps inside the build.xml file that ships with the component.

Run the command 'phing' in the component's top-level folder to see the full list of available automated tasks.

License
-------

See LICENSE.txt for full license details.
