from moviepy.editor import *
import math
import numpy as np
import scipy as sp

def power(arr):
	power=0
	for x in range(len(arr)):
		power+=(arr[x][0]**2)
		power+=(arr[x][1]**2)

	power=power/(len(arr)*2)
	#print(power)
	return power

for x in range(6):
	for y in range(27,28):
		baseNoise=AudioFileClip("bin/babble.wav")
		baseVideo=VideoFileClip("subclips/speaker"+str(x+1)+"/clip"+str(y+1)+"/base.mp4")
		baseSignal=baseVideo.audio
		noiseArr=[]
		signalArr=[]
		frames=baseSignal.iter_frames()
		for value in frames:
			signalArr.append(value)

		frames=baseNoise.iter_frames()
		for value in frames:
			noiseArr.append(value)

		signalPow=power(signalArr)
		noisePow=power(noiseArr)

		SNR=signalPow/noisePow
		SNRdb=10*math.log10(SNR)

#		print(signalPow)
#		print(noisePow)
#		print("")
#		print(SNR)
		print(SNRdb)
		print("")

		while SNRdb<=-3.1 or SNRdb>=-2.9:
			if SNRdb<-3.1:
				if abs(SNRdb-(-3.1))>1:
					baseNoise=baseNoise.volumex(0.85)
				else:
					baseNoise=baseNoise.volumex(0.95)
			if SNRdb>-2.9:
				if abs(SNRdb-(-2.9))>1:
					baseNoise=baseNoise.volumex(1.2)
				else:
					baseNoise=baseNoise.volumex(1.02)
			frames=baseNoise.iter_frames()
			noiseArr=[]
			for value in frames:
				noiseArr.append(value)
			noisePow=power(noiseArr)
			SNR=signalPow/noisePow
			SNRdb=10*math.log10(SNR)
			print(SNRdb)

#		SNR=signalPow/noisePow
#		SNRdb=10*math.log10(SNR)

#		print(signalPow)
#		print(noisePow)
#		print("")
#		print(SNR)
#		print(SNRdb)
#		print("\n\n")

		baseNoise.write_audiofile("subclips/speaker"+str(x+1)+"/clip"+str(y+1)+"/noise.wav")