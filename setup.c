#include <stdio.h>
#include <wiringPi.h>

int main (void)
{
	printf("Raspberry Pi WiringPi Setup => ");

	wiringPiSetup () ;

	printf("[OK]\n");

	return 0 ;
}
