#!/bin/sh

export NODE_ENV=production
export PATH=/usr/local/bin:$PATH
forever start /node/server/path/server.js > /dev/null