# Please see the online documentation at
# https://docs.vagrantup.com.

# OPTIONS
require 'yaml'
options = YAML.load_file File.join(File.dirname(__FILE__), 'vagrant.yaml')
domains = [
    "madeasy.dev",
    "backend.madeasy.dev",
    "storage.madeasy.dev"
]
packages = [

]

Vagrant.configure(2) do |config|
  config.vm.post_up_message = "Done! Now you can access site at http://madeasy.dev"

    config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = options['vm']['memory']
    vb.cpus = options['vm']['cpus']
  end


  config.vm.box = "ubuntu/trusty32"
  config.vm.hostname = domains[0]
  config.vm.network "private_network", ip: options['network']['ip']
  config.vm.synced_folder "./", "/var/www", id: "vagrant-root", :nfs => false, owner: "www-data", group: "www-data"

  config.vm.provision :hostmanager
  config.hostmanager.enabled            = true
  config.hostmanager.manage_host        = true
  config.hostmanager.ignore_private_ip  = false
  config.hostmanager.include_offline    = true
  config.hostmanager.aliases            = domains

  config.vm.provision "shell", path: "./vagrant.sh", args: [
    packages.join(" "),
    options['github']['token'],
    options['system']['swapsize']
  ]

  config.vm.provision "shell", inline: "service apache2 restart", run: "always"
end