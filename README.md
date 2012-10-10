LidaaTransBundle
================
[![Build Status](https://secure.travis-ci.org/lidaa/LidaaTransBundle.png)](http://travis-ci.org/lidaa/LidaaTransBundle)

Provides a web interface to manage translations of different project bundles


Requirement
============

- Symfony version 2.0.9 or later (2.0.x)

Installation
============

**1- Add the following lines in your deps file:**

	[LidaaTransBundle]
		 git=git://github.com/lidaa/LidaaTransBundle.git
		 target=/bundles/Lidaa/TransBundle


**2- Now, run the vendors script to download the bundle:**

	$ php bin/vendors install

**3- Add LidaaTransBundle to your application kernel:**

	// app/AppKernel.php
	public function registerBundles()
	{
		 return array(
		     // ...
		     new Lidaa\TransBundle\LidaaTransBundle(),
		     // ...
		 );
	}

**4- Add the 'Lidaa' namespace to your autoloader:**

	// app/autoload.php
	$loader->registerNamespaces(array(
		 //...
		 'Lidaa' => __DIR__.'/../vendor/bundles',
		 //...
	));

Usage
======
Load editor in browser

	app_dev.php/_translator/index


TODO
=====
- Add support for translation files based on xml or php

enjoy :)




