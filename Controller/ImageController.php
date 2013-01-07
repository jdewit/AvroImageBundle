<?php

namespace Avro\ImageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Avro\ImageBundle\Document\Image;
use Avro\ImageBundle\Form\Type\ImageFormType;
use Avro\ImageBundle\Form\Type\ObjectFormType;

/**
 * Image controller.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImageController extends ContainerAware
{
    /*
     * render an image
     */
    public function showAction($id)
    {
        $dm = $this->container->get('doctrine.odm.mongodb.document_manager');
        $file = $dm->getRepository('AvroImageBundle:File')->find($id);

        $response = new Response();

        $response->headers->set('Content-Type', 'image/png');

        $response->setContent($file->getFile()->getBytes());

        return $response;
    }

    public function editAction($alias, $id)
    {
        $params = $this->container->getParameter(sprintf('avro_image.%s', $alias));

        $objectManipulator = $this->container->get('avro_image.object_manipulator');
        $object = $objectManipulator->find($params['class'], $id);

        if ($params['by_slug']) {
            $backUri = $this->container->get('router')->generate($params['redirect_route'], array('slug' => $object->getSlug()));
        } else {
            $backUri = $this->container->get('router')->generate($params['redirect_route'], array('id' => $object->getId()));
        }

        $request = $this->container->get('request');

        $form = $this->container->get('form.factory')->create(new ObjectFormType($params['class']), $object);
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $objectManipulator->update($object);

                $this->container->get('session')->getFlashBag()->set('success', 'Images updated.');

                return new RedirectResponse($backUri);
            }
        }

        $editTemplate = $this->container->getParameter('avro_image.edit_template');


        return $this->container->get('templating')->renderResponse($editTemplate, array(
            'object' => $object,
            'form' => $form->createView(),
            'alias' => $alias,
            'backUri' => $backUri
        ));
    }
}
