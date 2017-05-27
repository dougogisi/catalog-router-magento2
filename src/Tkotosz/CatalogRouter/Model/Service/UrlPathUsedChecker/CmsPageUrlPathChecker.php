<?php

namespace Tkotosz\CatalogRouter\Model\Service\UrlPathUsedChecker;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as CmsPageCollectionFactory;
use Tkotosz\CatalogRouter\Api\UrlPathUsedChecker;
use Tkotosz\CatalogRouter\Model\UrlPath;
use Tkotosz\CatalogRouter\Model\UrlPathUsageInfo;

class CmsPageUrlPathChecker implements UrlPathUsedChecker
{
    /**
     * @var CmsPageCollectionFactory
     */
    private $cmsPageCollectionFactory;
    
    /**
     * @param CmsPageCollectionFactory $cmsPageCollectionFactory
     */
    public function __construct(CmsPageCollectionFactory $cmsPageCollectionFactory)
    {
        $this->cmsPageCollectionFactory = $cmsPageCollectionFactory;
    }
    
    /**
     * @param UrlPath $urlPath
     * @param int     $storeId
     *
     * @return UrlPathUsageInfo[]
     */
    public function check(UrlPath $urlPath, int $storeId) : array
    {
        $result = [];

        $pageCollection = $this->cmsPageCollectionFactory->create()
            ->addStoreFilter($storeId, true)
            ->addFieldToFilter('identifier', $urlPath->getLastPart());

        foreach ($pageCollection as $page) {
            $result[] = new UrlPathUsageInfo($page->getId(), 'cms page');    
        }

        return $result;
    }
}
