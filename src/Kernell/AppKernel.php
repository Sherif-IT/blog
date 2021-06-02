<?php


class AppKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        $bundles = [ 
            new Vich\UploaderBundle\VichUploaderBundle(), 
        ];
    }
}