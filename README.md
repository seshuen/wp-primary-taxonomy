# WP Primary Taxonomy

WordPress plugin that allows publishers to designate a primary category for posts.

## Installation

1. Plugin > WP Primary Taxonomy > Activate the plugin
2. Settings > WP Primary Taxonomy > Check all post type for which you wish to activate the primary category option
3. Add/Edit any post from enabled post types > At the bottom of sidebar > WP Primary Taxonomy > Select any category which has been enabled for the post as primary > Update

## Assumptions

The goal of this plugin is to simply add functionality to have a primary category option just for the main taxonomy. This plugin is not extended for custom taxonomies types.

## Coding Thought Process

The goal of this exercise was to see how I can use my existing knowledge on Wordpress and how I can learn about things I didnt know about. I stuck to basic and focused on creating a plugin which can update post meta data which can be extended in WP query. There was not much modules to the exercise. The project majorly consisted of two main parts:

- Connecting post meta data to post taxonomies
- Connecting post type to its post meta data

## Milestones for the plugin

This section will describe each milestones for this project and how much time each took. Each timestamp are in progression of 15 mins. For ex. 15 mins = 0.25, 45 mins = 0.75 etc.

1. Creating boileplate for the plugin - 0.5
2. Create basic plugin which can add primary taxonomy post meta - 0.25
3. Integrate primary taxonomy post meta and the main taxonomies in post edit page - 2
4. Create settings page for the plugin - 0.25
5. Add option to enable primary category meta box for only post types which has been enabled - 1.5
6. Run visual regression test on the plugin by adding new post types and query them with primary category - 1.0
7. Document about the plugin - 0.5
   Overall time spent - 6 hrs
