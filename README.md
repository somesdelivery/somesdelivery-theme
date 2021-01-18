# somesdelivery-theme

This is the Wordpress theme for [Someș Delivery](https://somesdelivery.ro). It builds on the [Timber starter theme](https://github.com/timber/starter-theme).

## Setting up a new website

1. Install Wordpress
2. Change the website title & tagline, switch language to Romanian
3. Install the list of plugins (see section below)
4. Create categories:
4.1. Noutăți (slug `noutati`)
5. Add terms to the `categorie_proiect` custom taxonomy: `Evenimente`, `Instalații`, `Amenajări`, etc.
6. Import the ACF custom field definitions from the `config` folder
7. Start creating content
8. Create main navigation menu from the Menu Builder

## Plugins used by this theme

#### Timber ([website](http://upstatement.com/timber/))

> Timber helps you create fully-customized WordPress themes faster with more sustainable code. With Timber, you write your HTML using the Twig Template Engine separate from your PHP files.

#### ACF Pro ([website](https://www.advancedcustomfields.com/))

> Custom fields. Made easy.

#### Facebook Open Graph, Google+ and Twitter Card Tags ([website](https://wordpress.org/plugins/wonderm00ns-simple-facebook-open-graph-tags/))

> Inserts Facebook Open Graph, Google+/Schema.org, Twitter and SEO Meta Tags into your WordPress Website for more efficient sharing results. 

## Custom post types

#### Proiect

Slug: `proiecte/`

Used to denote a single project, be it in the contest, or a project by the SD team or our partners.

#### Ediție

Slug: `editii/`

Used to denote an edition of Someș Delivery (2015, 2016, etc.)

## Custom Fields

#### Proiect

* __editie:__ Page link to corresponding Ediție object
* __galerie:__ Image gallery

#### Ediție

* __galerie:__ Image gallery

## Custom taxonomies

### Categorie proiect