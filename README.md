SlidesGeneratorBundle
=====================

[![Build Status](https://travis-ci.org/thormeier/slides-generator-bundle.png?branch=master)](https://travis-ci.org/thormeier/slides-generator-bundle)

## Introduction

This Symfony bundle provides a command to generate slides for Sprint review presentations based on the git commit history.

## Installation

### Step 1: Composer require

    $ php composer.phar require "thormeier/breadcrumb-bundle"

### Step 2: Enable the bundle in the kernel

    <?php
    // app/AppKernel.php
    
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Thormeier\SlidesGeneratorBundle\ThormeierSlidesGeneratorBundle(),
            // ...
        );
    }

## Configuration

Enable the bundle in your config.yml:

    # config.yml
    thormeier_slides_generator:
        identifier_pattern: "/(TICKET [0-9]+)/"

Note that the `identifier_pattern` is required. There's no default. More on this further down.

The complete configuration is as follows:

    # config.yml
    thormeier_slides_generator:
        identifier_pattern:   ~ # Required
        keyword_add:          ':slides'
        repository_service:   thormeier_slides_generator.repository.git
        renderer_service:     thormeier_slides_generator.renderer.markdown
        generator_service:    thormeier_slides_generator.generator

## Usage

Start adding `:slides` to your git commit messages if you want to add them to the slides. Execute the Symfony command `slides:generate` to generate an output of the slides in the console.

### Changing the keyword to add a commit to the slides

If you want to use something different then `:slides` in your commit messages to indicate an adding to the slides of a commit, you can configure it like so:

    # config.yml
    thormeier_slides_generator:
        keyword_add: "add this to the slides"

The repository will look for the occurrence of this string in a commit message and adds the commit as a slide.

### Using a different pattern for ticket names

By using the regex `"/(TICKET [0-9]+)/"`, the first matching occurrence of something like `TICKET 1234` is used as the slides title/identifier. Multiple commits with the same identifier that contain the configured slides keyword are squashed into a single slide. 

You can configure the `identifier_pattern` like so:

    # config.yml
    thormeier_slides_generator:
        identifier_pattern: "/(TICKET [0-9]+)/"

Any valid regex will do.

### Replacing the git storage

To replace the git storage (default), define a service that implements the `Thormeier\SlidesGeneratorBundle\Repository\SlideRepositoryInterface` interface. You can then configure this service as your desired repository service in the config:

    # config.yml
    thormeier_slides_generator:
        repository_service: "acme.slides_renderer" # Replace `acme.slides_repository` with your service ID

You could then, for instance, use a database as your storage or implement something else entirely.

### Replacing the markdown renderer

To replace the markdown renderer (default), define a service that implements the `Thormeier\SlidesGeneratorBundle\Renderer\RendererInterface` interface. You can then configure this service as your desired rendering service in the config:

    # config.yml
    thormeier_slides_generator:
        renderer_service: "acme.slides_renderer" # Replace `acme.slides_renderer` with your service ID

You could then, for instance, make a Twig renderer or something else entirely.

### Replacing the whole generator

To replace the default generator, define a service that implements the `Thormeier\SlidesGeneratorBundle\Generator\SlidesGeneratorInterface` interface. You can then configure this service as your desired rendering service in the config:

    # config.yml
    thormeier_slides_generator:
        generator_service: "acme.slides_generator" # Replace `acme.slides_generator` with your service ID
