https://docs.microsoft.com/en-us/windows/wsl/install-win10

# Install Docker Desktop
- Check windows version is above 2004
> winver

Check wsl version
> wsl -l -v
stop 
> wsl --unregister docker-desktop

## WSL2
Doc link: 
> https://github.com/davidbombal/wsl2/blob/main/ubuntu_gui_youtube
Video Link
> https://youtu.be/IL7Jd9rjgrM

```sh
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart

dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
wsl --set-default-version 2

# !Ubuntu GUI commands:
sudo apt update && sudo apt -y upgrade
sudo apt-get purge xrdp
sudo apt install -y xrdp
sudo apt install -y xfce4
sudo apt install -y xfce4-goodies

sudo cp /etc/xrdp/xrdp.ini /etc/xrdp/xrdp.ini.bak
sudo sed -i 's/3389/3390/g' /etc/xrdp/xrdp.ini
sudo sed -i 's/max_bpp=32/#max_bpp=32\nmax_bpp=128/g' /etc/xrdp/xrdp.ini
sudo sed -i 's/xserverbpp=24/#xserverbpp=24\nxserverbpp=128/g' /etc/xrdp/xrdp.ini
echo xfce4-session > ~/.xsession

sudo nano /etc/xrdp/startwm.sh
## !comment these lines to:
#test -x /etc/X11/Xsession && exec /etc/X11/Xsession
#exec /bin/sh /etc/X11/Xsession

# !add these lines:
# xfce
startxfce4

sudo /etc/init.d/xrdp start

# !Now in Windows, use Remote Desktop Connection
localhost:3390
# !Then login using your Ubuntu username and password
```

## ubuntu LTS / Windows Terminal
> cd /mnt/d/dev/project

> git clone project.git
>docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install
> .env
> sail up
