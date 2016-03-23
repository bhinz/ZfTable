[![Build Status](https://travis-ci.org/fagundes/ZffTable.svg?branch=master)](https://travis-ci.org/fagundes/ZffTable)
[![Latest Stable Version](https://poser.pugx.org/fagundes/zff-table/v/stable.svg)](https://packagist.org/packages/fagundes/zff-table) [![Total Downloads](https://poser.pugx.org/fagundes/zff-table/downloads.svg)](https://packagist.org/packages/fagundes/zff-table) [![License](https://poser.pugx.org/fagundes/zff-table/license.svg)](https://packagist.org/packages/fagundes/zftable)

ZffTable 3.2 [See on live v3.1](http://dudapiotr.eu)
=======
Original project created by Piotr Duda

Version 3.2 Created by Vinícius Fagundes


Download
-----------
[Complete site 3.1: dudapiotr.eu](https://drive.google.com/file/d/0B4WJ3MxrRUAEOWp5emFaNlpBNGM/edit?usp=sharing)


Introduction
------------

Awesome table/grid (and much much more) generator with huge possibilities of decorating and conditioning. 
Integrated with DataTables, Doctrine 2, Bootstrap 2.0 and 3.0.

Contributors
------------
If you want to help develop this module please don't hesitate. 
Thanks for cooperation:

- olekhy (https://github.com/olekhy)
- alejandro-fiore (https://github.com/alejandro-fiore)
- julillosamaral (https://github.com/julillosamaral)
- drchav (https://github.com/drchav)  (DataTable 1.10 Changes)

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)


Features
----------------
-  Flexible generating table
-  Decoratoring headers, rows and cell
-  Conditional decorating (Greater, Lesser, Equal, NotEqual, Between)
-  Simply Integration with DataTables (last integrity 1.10)
-  Pagination, QuickSearch, Sorting and Items per page
-  Default Bootstrap layout - support for Bootstrap 3.0 and 2.2.2
-  Simple customization (show in example -  we can change table view to any view eq list of articles with all features like pagination, quicksearch, sorint and item per page)
-  Editable decorator -> the ability to edit data from the table level
-  Filtering for each column
-  Row decorator for separating row by ordering column (dividing the same data)
-  Exporter data to CVS
-  Callable decorator
-  Doctrine 2 Adapter (Source)
-  Array Adapter  (Source)
-  JavaScript Events (Callable Events)
-  Possibility to send additional params
-  Asset manager functionality (https://github.com/RWOverdijk/AssetManager)
-  Visio Crud Module integration (https://github.com/HyPhers/visio-crud-zf2/)
-  DecoratorPluginManager as a service - it's easier create new decorators
-  Partial decorator

Changes in Version 3.2
----------------
- DecoratorPluginManager as a Service (it's possible add new decorators from created by factory and also possible create it in third part sources)
- Improve Link decorator (now it is created by LinkFactory which inject BasePathHelper to create correctly urls)
- Partial decorator for reusing content cells between tables

Changes in Version 3.1
----------------
- Asset manager functionality (https://github.com/RWOverdijk/AssetManager)

Changes in Version 3.0
----------------
- Callable decorator
- Doctrine 2 Adapter (Source)
- Array Adapter  (Source)
- JavaScript Events (Callable Events)
- Possibility to send additional params


Changes in Version 2.0
----------------
-  Editable decorator -> the ability to edit data from the table level
-  Filtering for each column
-  Row decorator for separating row by ordering column (dividing the same data)
-  New conditions
-  Exporter data to CVS
-  Support for Bootstrap 3.0


In next versions
----------------
- MongoDB adapter
- Export only selected data
- Add dynamically (by ajax) new row
- More decorators and conditions
- Adapter for JGrid
- Exporter (PDFV)
- New site for examples in GH Pages
- A full ZF2 project as a repository


Installation
------------

Installation description has been moved to wiki
https://github.com/dudapiotr/ZfTable/wiki/Installation-and-Configuration


Examples [See on live v3.1](http://dudapiotr.eu)
-------
In Example directory there is a couple of examples how use decorators and generate table. After added js and css file
to your layout view, in controller there are a table calls(based on data from ZF2 tutorial - album).
