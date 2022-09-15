Omnicasa for MODX
-----------------

This is an integration with [Omnicasa](https://www.omnicasa.com/) for MODX Revolution.


## Synchronisation

A [Scheduler](https://modmore.com/extras/scheduler/) task is provided to synchronise data from the API with a local database. Make sure Scheduler is installed before installing the Omnicasa package to have it registered, and that Scheduler is set up with a cron job to run in the background. 

Then, just schedule it once via the Scheduler dashboard to kick off a recurring full synchronisation. 

A dashboard widget is also provided. Add it to your dashboard to see synchronisation status and to trigger an extra synchronisation on-demand.

## Listing properties

The `omnicasa.list` snippet can be used for generating a list of properties. It is compatible with getPage/pdoPage for pagination and supports different filtering options.

Basic example with pagination and accepting user-provided WebID and Zip values:

```html 
<ul>
    [[!getPage? 
        &element=`omnicasa.list` 
        &acceptFromUrl=`WebID,Zip` 
        &cacheOutput=`0` 
        &tpl=`propertyTpl`
    ]]
</ul>
<div class="pageNav">[[!+page.nav]]</div>
```

When implementing the package, make sure to temporarily use ``&cacheOutput=`0` `` to disable the cache. When enabled, the output will be cached to avoid requesting data or parsing repeatedly, so changes to the `&tpl` would not show up. 

When you're done, re-enable the cache for the best performance. The internal cache is automatically cleared with every synchronisation.

The following properties are available in the `omnicasa.list` snippet:

| Property         | Description                                                                                                                                                                                                                                                                                                                                     | Default                       |
|------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------|
| `&tpl`           | Provide the name of a chunk to render individual properties with.                                                                                                                                                                                                                                                                               | `propertyTpl` (not installed) |
| `&totalVar`      | Used by getPage/pdoPage to control the placeholder name for the total number of results. If you have multiple paginated snippet calls on the same page, each one needs its own totalVar.                                                                                                                                                        | `total`                       |
| `&limit`         | Maximum number of results to return per page.                                                                                                                                                                                                                                                                                                   | 10                            |
| `&offset`        | Index of the result to start results.                                                                                                                                                                                                                                                                                                           | 0                             |
| `&sortby`        | Field to sort the results by. For example `CreatedDate`, `LastChangedDate`, `Zip`, `Price`, etc. Only [indexed fields](https://github.com/modmore/Omnicasa/blob/main/omnicasa.mysql.schema.xml) can be used for the sort order.                                                                                                                 | `CreatedDate`                 |
| `&sortdir`       | Either `ASC` or `DESC` to control the sort direction                                                                                                                                                                                                                                                                                            | `DESC`                        |
| `&acceptFromUrl` | Comma-separated list of field names that user-provided filtering is accepted on through a GET or POST parameter. For example, providing `Zip` will allow the `Zip` URL parameter to be used for filtering on `Zip`. Special behavior is built-in for `Price_min` and `Price_max`; when provided it will search the Price column for that range. | (empty)                       |
| `&where`         | Generic filter property, provide a JSON string. For example ```&where=`{"SubStatus:!=": "6"}` ``` which will hide properties that have been sold. Note that valid JSON means double quotes! Only [indexed fields](https://github.com/modmore/Omnicasa/blob/main/omnicasa.mysql.schema.xml) can be used in conditions.                           | (empty)                       |
| `&detailPrefix`  | The URL prefix for linking to the detail pages. For example `properties` would create URLs as `properties/{alias-of-property}`. Note that friendly URLs are required, see detail page instructions below.                                                                                                                                       | Link to the current page      |

The tpl chunk has access to all data in the Omnicasa API. For a look at all the available data, add `[[+dump]]` and view the page. The exact available data seems to occasionally differ from property to property, so be aware of that: check if values are set.

Very minimal `&tpl` example:

```html 
<li>
    <h2>#[[+oc_ID]] - [[+Ident]]</h2>
    <a href="[[+url]]">[[+descriptionA:htmlent:nl2br]]</a>
</li>
```

## Detail pages

A single "template resource" must be setup for detail pages. You'll need to use a rewrite, .htaccess example below, to route requests to detail pages to this template resource.

For example:

```
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^properties/(.+)$ index.php?id=12&slug=$1 [L,QSA]
```

where `12` is the ID of the template resource, and `properties` matches the `&detailPrefix` on the `omnicasa.list` snippet.

On the template resource, call `[[!omnicasa.single]]` and use uncached placeholders prefixed with `property.` to access property data. 

You can use `[[!+property.dump]]` to get a look at all data, or `[[!+property.json]]` to get a JSON object of the data to pass into a client-side rendering library like React. 

A `[[!+property.url]]` placeholder is available for the canonical heading.

If a property with the alias can't be found, the `omnicasa.list` snippet will redirect the user 

The following snippet properties are available for the `omnicasa.single` snippet:

| Property        | Description                                                                                                                                                                                                                                                                            | Default                       |
|-----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------|
| `&thumbnailTpl` | Provide the name of a chunk to render thumbnails. This uses the "Medium" images provided by the API. Within the chunk, the following placeholders exist: `[[+Url]]`, `[[+Width]]`, `[[+Height]]`, `[[+Name]]`. The parsed thumbnails list is available as `[[!+property.Thumbnails]]`. | (empty)                       |
| `&imageTpl`     | Provide the name of a chunk to render large images. This uses the "XLarge" images provided by the API. Within the chunk, the following placeholders exist: `[[+Url]]`, `[[+Width]]`, `[[+Height]]`, `[[+Name]]`. The parsed thumbnails list is available as `[[!+property.Images]]`.   | (empty)                       |
| `&detailPrefix` | The URL prefix for linking to the detail pages. For example `properties` would create URLs as `properties/{alias-of-property}`. Note that friendly URLs are required, see detail page instructions below.                                                                              | Link to the current page      |

An example for the `&thumbnailTpl` and `&imageTpl`:

```html
<li><img src="[[+Url]]" width="[[+Width]]" height="[[+Height]]" alt="[[+Name:htmlent]]"></li>
```

## Listing Property Types

With the `omnicasa.propertyTypes` snippet, it's possible to list all unique property types that are currently in the result set for properties. 

Available properties:

| Property         | Description                                                                                                                                                                                                                                          | Default                  |
|------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------|
| `&tpl`           | Provide the name of a chunk to render individual property types. In the chunk, you can use `[[+WebID]]`, `[[+WebIDName]]` and `[[+Count]]` placeholders.                                                                                             | (empty)                  |
| `&sortby`        | Field to sort the results by. One of `WebID`, `WebIDName`, or `Count`.                                                                                                                                                                               | `WebIDName`              |
| `&sortdir`       | Either `ASC` or `DESC` to control the sort direction                                                                                                                                                                                                 | `ASC`                    |
| `&where`         | Generic filter property, provide a JSON string. This applies to the properties, so for example ```&where=`{"SubStatus:!=": "6"}` ``` will hide property types that only has properties in the sold status. Note that valid JSON means double quotes! | (empty)                  |

An example to render radio buttons that pass the WebID as URL parameter:

```html 
<form method="GET" action="[[~[[*id]]]]">
    [[!omnicasa.propertyTypes? &tpl=`ocPropertyType` &cache=`0`]]
</form>
```

And in the `ocPropertyType` chunk:

```html 
<label style="display: block;">
    <input type="radio" name="WebID" value="[[+WebID]]">
    [[+WebIDName]] ([[+Count]]) 
</label>
```



