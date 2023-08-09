<?php

namespace Drupal\custom_menu\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;

/**
 * Event subscriber to display messages on movie nodes based on budget.
 */
class BudgetMovieEventSubscriber implements EventSubscriberInterface {

  protected $configFactory;
  protected $entityTypeManager;
  protected $messenger;

  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger) {
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::VIEW][] = ['onKernelView'];
    return $events;
  }

  /**
   * Display messages on movie nodes based on budget.
   */
  public function onKernelView(ViewEvent $event) {
    $request = $event->getRequest();
    $route_match = \Drupal::routeMatch();

    if ($route_match->getRouteName() == 'entity.node.canonical' && $request->attributes->has('node')) {
      $node = $request->attributes->get('node');

      if ($node->getType() == 'custom_movie') {
        $config = $this->configFactory->get('budget_movie_amount.settings');
        $budget_amount = $config->get('budget_amount');

        if ($budget_amount !== null) {
          $movie_price = $node->get('movie_price')->value;

          if ($movie_price < $budget_amount) {
            $this->messenger->addMessage(('The movie is under budget'));
          } elseif ($movie_price > $budget_amount) {
            $this->messenger->addMessage(('The movie is over budget'));
          } else {
            $this->messenger->addMessage(('The movie is within budget'));
          }
        }
      }
    }
  }
}
