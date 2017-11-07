<?php

namespace Pierre\BonsPlansBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapBlogPostSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ObjectManager $manager
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ObjectManager $manager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'registerBonsPlansPostsPages',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function registerBonsPlansPostsPages(SitemapPopulateEvent $event)
    {
        $posts = $this->manager->getRepository('PierreBonsPlansBundle:BonsPlan')->findAll();

        foreach ($posts as $post) {
            $event->getUrlContainer()->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'PierreBonsPlansBundle_bonsplan_show',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                    new \DateTime(),
                    UrlConcrete::CHANGEFREQ_WEEKLY,
                    1
                ),
                'bonsplan'
            );
        }

//        $cities = $this->manager->getRepository('PierreConnaitresesaidesBundle:City')->findAll();
//
//        foreach ($cities as $city) {
//            $event->getUrlContainer()->addUrl(
//                new UrlConcrete(
//                    $this->urlGenerator->generate(
//                        'PierreBonsPlansBundle_bonsplans_city',
//                        ['city' => $city->getName()],
//                        UrlGeneratorInterface::ABSOLUTE_URL
//                    ),
//                    new \DateTime(),
//                    UrlConcrete::CHANGEFREQ_WEEKLY,
//                    1
//                ),
//                'bonsplan'
//            );
//        }
    }
}