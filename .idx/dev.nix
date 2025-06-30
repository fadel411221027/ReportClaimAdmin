{pkgs}: {
  channel = "stable-24.05";
  packages = [
    pkgs.nodejs_20
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.sqlite
    pkgs.mysql
    pkgs.mysql-client
    pkgs.mysql84
  ];
  idx.extensions = [
    "svelte.svelte-vscode"
    "vue.volar"
  ];
  idx.previews = {
    previews = {
      web = {
        command = [];
        manager = "web";
      };
    };
  };
  services.mysql = {
  enable = true;
  package = pkgs.mariadb;
  };
}
