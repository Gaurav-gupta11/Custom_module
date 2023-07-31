<?php

namespace Drupal\custom_block_module\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Redirects users to the custom welcome page after login.
 */
class CustomWelcomeRedirectSubscriber implements EventSubscriberInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructor for CustomWelcomeRedirectSubscriber.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match.
   */
  public function __construct(AccountInterface $current_user, RouteMatchInterface $route_match) {
    $this->currentUser = $current_user;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'checkLoginRedirect',
    ];
  }

  /**
   * Check if the user has just logged in and redirect to the custom welcome page.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The response event.
   */
  public function checkLoginRedirect(ResponseEvent $event) {
    if ($this->routeMatch->getRouteName() === 'user.login' && $this->currentUser->isAuthenticated()) {
      // Change '/custom-welcome-page' to your actual custom welcome page path.
      $your_custom_path = '/custom-welcome-page';
      $response = new RedirectResponse($your_custom_path);
      $event->setResponse($response);
    }
  }

}
