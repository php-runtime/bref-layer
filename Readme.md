# Bref layers for PHP Runtime

This repository provides Bref layers to run Symfony Runtime applications on
AWS Lambda. It is automatically updated to sync with the changes in [Bref](https://github.com/brefphp/bref).
These layers are just replacing Bref's "function layer" with a new boostrap file.
See the [Dockerfile](https://github.com/php-runtime/bref-layer/blob/main/layers/bref/Dockerfile).

You will find more information how to run your applicaiton with the runtime component
at https://github.com/php-runtime/bref

## Install and configure

```cli
composer require runtime/bref-layer
```

```yaml
# serverless.yml
service: appgit init

provider:
    name: aws
    region: us-east-1
    runtime: provided.al2

plugins:
    - ./vendor/runtime/bref-layer # <----- Add the extra Serverless plugin

functions:
    website:
        handler: public/index.php
        layers:
            - ${runtime-bref:php-80}
        events:
            -   httpApi: '*'
```

You will use the same layer for console applications, PSR-11, PSR-15, Laravel or
Symfony applications. Anything the Runtime component supports.

## Available layers

These are the available layers:

- `${runtime-bref:php-81}`
- `${runtime-bref:php-80}`
- `${runtime-bref:php-74}`
- `${runtime-bref:php-73}`

## FAQ

#### Can I use custom php extensions?

Yes, you can. See the [`bref/extra-php-extensions`](https://github.com/brefphp/extra-php-extensions)
package.

#### Do I need to install bref/bref?

The [`bref/bref`](https://github.com/brefphp/bref) package includes both layers
and a lot of features to make it easier to write applications on AWS Lambda.
You do not **have to** include `bref/bref` if you only want the layers. But most
HTTP applications probably will.

#### Why not include this package in bref/bref?

There is [an open PR](https://github.com/brefphp/bref/pull/889) to do just that.
There is also [an open PR](https://github.com/brefphp/bref/pull/1034) to make the
function layer support the runtime component natively.

Until any of these PRs are merged, we have this layer to help making a good experience
as possible for the runtime users.

#### Why not use the layer from bref/extra-php-extensions?

The [bref/extra-php-extensions](https://github.com/brefphp/extra-php-extensions)
has a layer called `${bref-extra:symfony-runtime-php-74}`. It adds the custom bootstrap
file needed for the Runtime component.

AWS has a hard limit on max 5 layers per function. So instead of using two layers
(`${bref:layer.php-80}` + `${bref-extra:symfony-runtime-php-74}`) one can use only
`${runtime-bref:php-80}`.

#### What is your relation to Bref?

We **LOVE** Bref. They are the best ever. Consider sponsoring [Matthieu Napoli
](https://github.com/mnapoli) for his work.

## Maintainer notes

### Testing the layer

```
# Test all layers and PHP versions
make test

# Test only a single layer
layer=bref make test

# Test a single layer on a single PHP version
layer=bref php_versions=74 make test
```

### Deploy new versions

#### The manual way

```
export AWS_PROFILE=my_profile
make publish
git add layers.json
git commit -m "New version of layers"
git push
```

## Lambda layers in details

> **Notice:** this section is only useful if you want to learn more.

The lambda layers follow this pattern:

```
arn:aws:lambda:<region>:403367587399:layer:bref-<layer-name>:<layer-version>
```

See the [latest layer versions](https://raw.githubusercontent.com/php-runtime/bref-layer/main/layers.json).
