# Putty
Install
```
sudo apt-get install putty-tools
```

Convert from *pem* to *ppk* in linux terminal
> puttygen file.pem -o newfile.ppk -O private

example:
> puttygen D:/Downloads/dev/guidely/live/guidely.pem -o D:/Downloads/dev/guidely/live/guidelyppk.ppk -O private


Convert from *ppk* to *pem* (Privacy-Enhanced Mail) in linux terminal
> puttygen file.ppk -O private-openssh -o newfile.pem
