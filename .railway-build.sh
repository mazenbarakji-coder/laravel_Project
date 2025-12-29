#!/bin/bash
set -e

# Install bison required for PHP compilation
apt-get update && apt-get install -y bison

# Continue with normal Railway build
mise install

