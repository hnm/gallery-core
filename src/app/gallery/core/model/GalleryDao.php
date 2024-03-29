<?php
namespace gallery\core\model;

use n2n\persistence\orm\EntityManager;
use n2n\context\RequestScoped;
use gallery\core\bo\GalleryGroup;
use gallery\core\bo\GalleryGroupT;
use n2n\persistence\orm\util\NestedSetUtils;
use gallery\core\bo\Gallery;
use n2n\util\type\CastUtils;
use gallery\core\bo\GalleryT;

class GalleryDao implements RequestScoped {
	private $em;
	
	private function _init(EntityManager $em) {
		$this->em = $em;
	}
	
	/**
	 * @param string $pathPart
	 * @param GalleryGroup $rootGalleryGroup
	 * @return Gallery[]
	 */
	public function getGalleryGroupPathByPathPart(string $pathPart, GalleryGroup $rootGalleryGroup = null) {
		$galleryGroupT = $this->em->createSimpleCriteria(GalleryGroupT::getClass(), array('pathPart' => $pathPart))
				->toQuery()->fetchSingle();

		if ($galleryGroupT === null) return array();
		
		CastUtils::assertTrue($galleryGroupT instanceof GalleryGroupT);
		
		$nsu = new NestedSetUtils($this->em, GalleryGroup::getClass());
		$galleryGroups = array();
		
		foreach ($nsu->fetchParents($galleryGroupT->getGalleryGroup(), true) as $galleryGroup) {
			$galleryGroups[] = $galleryGroup;
			
			if (null !== $rootGalleryGroup && $galleryGroup->getId() == $rootGalleryGroup->getId()) {
				return array_reverse($galleryGroups);
			}
		}
		
		if (null === $rootGalleryGroup) {
			return $galleryGroups;
		}
		
		return $galleryGroups;
	}
	
	/**
	 * 
	 * @param string $pathPart
	 * @param GalleryGroup $galleryGroup
	 * @return NULL|\gallery\core\bo\Gallery
	 */
	public function getGalleryByPathPart(string $pathPart, GalleryGroup $galleryGroup = null) {
		$galleryT = $this->em->createSimpleCriteria(GalleryT::getClass(), array('pathPart' => $pathPart))
				->toQuery()->fetchSingle();
		if ($galleryT === null) return null;
		
		CastUtils::assertTrue($galleryT instanceof GalleryT);
		
		if ($galleryGroup === null || $galleryGroup->getId() == $galleryT->getGallery()->getGalleryGroup()->getId()) {
			return $galleryT->getGallery();
		}
		
		return null;
	}
	
	public function getGalleries() {
		return $this->em->createSimpleCriteria(Gallery::getClass(), array('online' => true), 
				array('id' => 'DESC'))->toQuery()->fetchArray();
	}
	
	/**
	 * @param GalleryGroup $galleryGroup
	 * @return GalleryGroup []
	 */
	public function getChildrenOfGalleryGroup(GalleryGroup $galleryGroup = null) {
		$nsu = new NestedSetUtils($this->em, GalleryGroup::getClass());
		
		$childGalleryGroups = array();
		$level = null;
		foreach ($nsu->fetch($galleryGroup, true) as $nsi) {
			if ($level === null) {
				$level = $nsi->getLevel();
			} else if ($level != $nsi->getLevel()) {
				continue;
			}
			
			$childGalleryGroup = $nsi->getEntityObj();
			if ($childGalleryGroup->isOnline()) {
				$childGalleryGroups[] = $childGalleryGroup;
			}
		}
		return $childGalleryGroups;
	}
	
	public function getNumGalleries(GalleryGroup $galleryGroup) {
		$numGalleries = $galleryGroup->getNumGalleries();
		
		$nsu = new NestedSetUtils($this->em, GalleryGroup::getClass());
		
// 		$childGalleryGroups = array();
		$level = null;
		foreach ($nsu->fetch($galleryGroup, true) as $nsi) {
			$childGalleryGroup = $nsi->getEntityObj();
			if ($childGalleryGroup->isOnline()) {
				$numGalleries += $childGalleryGroup->getNumGalleries();
			}
		}
		
		return $numGalleries;
	}
}
