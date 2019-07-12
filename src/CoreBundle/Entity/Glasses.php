<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Glasses
 *
 * @ORM\Table(name="glasses")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\GlassesRepository")
 */
class Glasses
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="productName", type="string", length=255)
     */
    private $productName;
    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", length=255)
     */
    private $price;
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=255)
     */
    private $sex;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description = "default description";
    /**
     * @var string
     *
     * @ORM\Column(name="rate", type="string", length=255)
     */
    private $rate = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="imgRoute", type="string", length=255)
     */
    private $imgRoute;

    public $cartQuantity;
    public $subtotal;
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }
    public function getSubtotal()
    {
        return $this->subtotal;
    }
    public function setCartQuantity($cartQuantity)
    {
        $this->cartQuantity = $cartQuantity;
    }
    public function getCartQuantity()
    {
        return $this->cartQuantity;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $productName
     *
     * @return Glasses
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Glasses
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Glasses
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set imgRoute
     *
     * @param string $imgRoute
     *
     * @return Glasses
     */
    public function setImgRoute($imgRoute)
    {
        $this->imgRoute = $imgRoute;

        return $this;
    }

    /**
     * Get imgRoute
     *
     * @return string
     */
    public function getImgRoute()
    {
        return $this->imgRoute;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Glasses
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set rate
     *
     * @param string $rate
     *
     * @return Glasses
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Glasses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
