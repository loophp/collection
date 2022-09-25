{
  description = "loophp/collection";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixpkgs-unstable";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs = { self, nixpkgs, flake-utils, ... }@inputs:
    with flake-utils.lib; eachSystem allSystems (system:
      let
        version = self.shortRev or self.lastModifiedDate;

        pkgs = import nixpkgs {
          inherit system;
          config = {
            allowUnfreePredicate = (pkg: true);
          };
        };

        tex = pkgs.texlive.combine {
          inherit (pkgs.texlive) scheme-full latex-bin latexmk;
        };

        documentProperties = {
          name = "loophp-collection";
          inputs = [
            tex
            pkgs.sphinx
            pkgs.sphinx-autobuild
            pkgs.python3Packages.sphinx_rtd_theme
            pkgs.python3Packages.sphinxcontrib-spelling
            pkgs.python3Packages.recommonmark
            pkgs.python3Packages.pyenchant
          ];
        };

        pdf = pkgs.stdenv.mkDerivation {
          name = documentProperties.name + "-documentation-pdf";

          src = self;

          nativeBuildInputs = documentProperties.inputs;

          buildPhase = ''
            sphinx-build -M latexpdf ./docs build/docs
          '';

          installPhase = ''
            install -m 0644 -vD build/docs/latex/loophp-collection-documentation.pdf $out
          '';
        };

        wrapper-autobuild = pkgs.writeScriptBin "autobuild" ''
            ${sphinx-build}/bin/sphinx-autobuild ./docs build/docs
        '';

        autobuild = pkgs.stdenv.mkDerivation {
          name = documentProperties.name + "-documentation-autobuild";

          src = self;

          buildInputs = [ wrapper-autobuild ];

          nativeBuildInputs = documentProperties.inputs;

          installPhase = ''
            mkdir -p $out/bin
            cp -r ${wrapper-autobuild}/bin/* $out/bin/
          '';
        };

      in
      rec {
        # nix run
        apps.default = flake-utils.lib.mkApp { drv = autobuild; };

        # nix shell, nix build
        packages = {
          pdf = pdf;
          default = self.packages.${system}.pdf;
        };

        # nix develop
        devShells =  {
            default = pkgs.mkShellNoCC {
              name = documentProperties.name;
              buildInputs = documentProperties.inputs;
            };
        };
      });
}
