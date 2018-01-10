# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "phonetworks/xenial-pho"
  config.vm.box_version = ">= 2.1.0"
  config.vm.synced_folder "./", "/opt/pho-kernel"
  config.vm.provision :shell, path: "bin/bootstrap.sh"
  ## in case of network connectivity issues
  config.vm.provider "virtualbox" do |v|
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
  end
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
  end
end
