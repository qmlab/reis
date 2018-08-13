#!/bin/bash
pushd /home/mian/qmlab/reis
if [ -f /mnt/c/Users/maine/Downloads/Full.txt ]; then
	mv /mnt/c/Users/maine/Downloads/*.txt cache/
	hhvm ingestion/matrix.hh
	rm cache/*
	date >> executions.log
fi
popd
