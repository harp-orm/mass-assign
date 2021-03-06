<?php

namespace Harp\MassAssign;

use Harp\Util\Arr;
use Harp\Core\Model\AbstractModel;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Data extends UnsafeData
{
    protected $permitted;

    public function __construct(array $data, array $permitted)
    {
        parent::__construct($data);

        $this->permitted = Arr::toAssoc($permitted);
    }

    public function getPermitted()
    {
        return $this->permitted;
    }

    public function getPropertiesData(AbstractModel $node)
    {
        $rels = $node->getRepo()->getRels();

        $data = array_intersect_key($this->data, $this->permitted);

        return array_diff_key($data, $rels);
    }

    public function getRelData(AbstractModel $node)
    {
        $rels = $node->getRepo()->getRels();

        $relData = array_intersect_key($this->data, $rels);

        foreach ($relData as $relName => & $data) {
            $permitted = isset($this->permitted[$relName]) ? $this->permitted[$relName] : [];
            $data = new Data($data, $permitted);
        }

        return $relData;
    }

    public function getArray()
    {
        return array_map(function ($data) {
            return new Data($data, $this->permitted);
        }, $this->data);
    }
}
