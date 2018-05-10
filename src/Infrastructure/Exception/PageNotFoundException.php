<?php
/**
 * This file is a part of Neko-Wiki package.
 *
 * (c) Nekland <dev@nekland.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Infrastructure\Exception;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageNotFoundException extends NotFoundHttpException
{

}
