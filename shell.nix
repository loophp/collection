{ pkgs ? (import <nixpkgs> {}), ... }:
with pkgs;
let
    php = php74;

    options = ''
            max_execution_time = 0
            xdebug.mode=debug
            memory_limit=-1
    '';

    phpOverride = php.buildEnv {
      extensions = { all, ... }: with all; [
        # Mandatory
        filter
        iconv
        ctype
        redis
        tokenizer
        simplexml

        # Recommendations
        dom
        posix
        intl
        opcache

        # Optional
        pcov
        pdo_sqlite
        pdo_mysql
        pdo_pgsql

        openssl
        calendar
        soap
        mbstring
        exif
        fileinfo
        gd
        curl
        zip
        xmlwriter
        xdebug
      ];
      extraConfig = options;
    };

in mkShell {
  name = "php74-dev";

  buildInputs = [
    # Install PHP and composer
    phpOverride
    phpOverride.packages.composer

    # Install GNU Make for shorthands
    gnumake

    # Install docker-compose
    docker-compose

    # Install nodejs for PHP LSP
    nodejs
  ];
}
